<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Services\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrentUserController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
        private readonly UserServiceInterface $userService,
    ) {
    }

    #[Route('/api/me', name: 'current_user', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $user = $this->security->getUser();
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
