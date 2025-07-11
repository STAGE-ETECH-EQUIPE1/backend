<?php

namespace App\Controller\Api;

use App\DTO\Request\RegisterDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationController extends AbstractController
{
    #[Route(
        path: '/register',
        name: 'register',
        methods: ['POST']
    )]
    public function register(
        #[MapRequestPayload]
        RegisterDTO $registerDto,
        ValidatorInterface $validator,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        $errors = $validator->validate($registerDto);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors' => $errorMessages], 400);
        }

        // Vérification mot de passe == confirmPassword
        if ($registerDto->password !== $registerDto->confirmPassword) {
            return new JsonResponse(['error' => 'Les mots de passe ne correspondent pas'], 400);
        }

        // Vérification utilisateur existant par email
        if ($em->getRepository(User::class)->findOneBy(['email' => $registerDto->email])) {
            return new JsonResponse(['error' => 'Un compte avec cet email existe déjà'], 400);
        }

        // Création utilisateur
        $user = new User();
        $user->setFullName($registerDto->fullName);
        $user->setUsername($registerDto->username);
        $user->setEmail($registerDto->email);
        $user->setPhone($registerDto->phone);

        $hashedPassword = $passwordHasher->hashPassword($user, $registerDto->password);
        $user->setPassword($hashedPassword);

        // $em->persist($user);
        // $em->flush();

        $token = $jwtManager->create($user);

        return $this->json([
            'token' => $token,
            'message' => 'Inscription réussie',
            'user' => [
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'lastName' => $user->getFullName()
            ]
        ], 201);
    }
}
