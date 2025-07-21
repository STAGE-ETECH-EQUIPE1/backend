<?php

namespace App\Controller\Api\Auth;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Token\AccessToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GoogleAuthenticationController extends AbstractController
{
    #[Route('/auth/google', name: 'auth_google', methods: ['POST'])]
    public function googleLogin(Request $request, ClientRegistry $clientRegistry, EntityManagerInterface $em, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['access_token'])) {
            return new JsonResponse(['error' => 'access_token manquant'], 400);
        }
        $client = $clientRegistry->getClient('google');
        $accessToken = new AccessToken(['access_token' => $data['access_token']]);
        $googleUser = $client->fetchUserFromToken($accessToken);

        /** @var \League\OAuth2\Client\Provider\GoogleUser $googleUser */
        $email = $googleUser->getEmail();
        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $user = new User();
            if (!is_string($email)) {
                throw new \InvalidArgumentException('Email must be a string');
            }
            /* @var \App\Entity\User $user */
            $user->setEmail($email);
            $user->setFullName($googleUser->getName());
            $user->setUsername($googleUser->getName());
            $user->setPassword(''); // à verifier
            // autre info : Phone, etc

            $em->persist($user);
            $em->flush();
        }

        $token = $jwtManager->create($user);

        return new JsonResponse([
            'token' => $token,
        ]);
    }
}
