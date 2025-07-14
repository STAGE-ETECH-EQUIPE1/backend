<?php

namespace App\Controller\Api;

use App\DTO\Request\UserRegistrationDTO;
use App\Services\User\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserRegistrationController extends AbstractController
{
    public function __invoke(
        UserRegistrationDTO $userRegistrationDto,
        UserServiceInterface $userService,
        EntityManagerInterface $entityManager,
    ): JsonResponse {
        $user = $userService->convertUserRegistrationDtoToUser($userRegistrationDto);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'message' => 'User registered successfully',
            'user' => $userService->convertToDto($user),
        ], Response::HTTP_CREATED);
    }
}
