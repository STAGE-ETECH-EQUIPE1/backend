<?php

namespace App\Controller\User;

use App\Entity\Auth\User;
use App\Services\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CurrentUserController extends AbstractController
{
    public function __construct(
        private readonly UserServiceInterface $userService,
    ) {
    }

    #[Route(
        path: '/me',
        name: 'current_user',
        methods: ['GET']
    )]
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
}
