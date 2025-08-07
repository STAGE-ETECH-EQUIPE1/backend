<?php

namespace App\Controller\Auth;

use App\DTO\Request\UserRegistrationDTO;
use App\Services\User\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends AbstractController
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly EntityManagerInterface $entityManager,
        private readonly JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public function __invoke(
        UserRegistrationDTO $userRegistrationDto,
    ): JsonResponse {
        $user = $this->userService->convertUserRegistrationDtoToUser($userRegistrationDto);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $token = $this->jwtManager->create($user);

        return $this->json([
            'message' => 'User Registration successful',
            'token' => $token,
            'user' => $this->userService->convertToDto($user),
            'statusCode' => Response::HTTP_CREATED,
        ], Response::HTTP_CREATED);
    }
}
