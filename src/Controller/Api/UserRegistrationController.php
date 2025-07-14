<?php

// src/Controller/Api/UserRegistrationController.php

namespace App\Controller\Api;

use App\DataTransformer\UserRegistrationDataTransformer;
use App\DTO\Request\UserRegistrationDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserRegistrationController extends AbstractController
{
    public function __invoke(
        UserRegistrationDTO $userRegistrationDto,
        UserRegistrationDataTransformer $transformer,
        EntityManagerInterface $entityManager,
    ): JsonResponse {
        $user = new User();
        $transformer->transform($userRegistrationDto, $user);

        // $entityManager->persist($user);
        // $entityManager->flush();
        return $this->json([
            'message' => 'User registered successfully',
            'email' => $user->getEmail(),
        ], Response::HTTP_CREATED);
    }
}
