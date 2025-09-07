<?php

namespace App\Controller\User;

use App\Services\DeleteUser\DeleteUserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeleteUserController extends AbstractController
{
    public function __construct(
        private DeleteUserServiceInterface $userService,
    ) {
    }

    #[Route('/user/delete/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function __invoke(
        int $id,
    ): JsonResponse {
        try {
            return $this->userService->deleteUserById($id);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Delete Error',
            ]);
        }
    }
}
