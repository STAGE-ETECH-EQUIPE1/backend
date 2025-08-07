<?php

namespace App\Controller\Auth;

use App\DTO\Request\UserRegistrationDTO;
use App\Entity\Auth\User;
use App\Services\User\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    #[Route('/me', name: 'current_user', methods: ['GET'])]
    public function getCurrentUser(): JsonResponse
    {
        $user = $this->getUser();
        if ($user && $user instanceof User) {
            return $this->json([
                'message' => 'Current authenticated user',
                'status' => Response::HTTP_OK,
                'data' => $this->userService->convertToJwtUser($user),
            ]);
        }

        return $this->json([
            'message' => 'User is not authenticated',
            'status' => Response::HTTP_UNAUTHORIZED,
            'data' => null,
        ]);
    }

    #[Route('/register', name: 'user_registration', methods: ['POST'])]
    public function registerUser(
        #[MapRequestPayload]
        UserRegistrationDTO $userRegistrationDto,
    ): JsonResponse {
        $user = $this->userService->convertUserRegistrationDtoToUser($userRegistrationDto);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'User registered successfully',
            'user' => $this->userService->convertToDto($user),
        ], Response::HTTP_CREATED);
    }
}
