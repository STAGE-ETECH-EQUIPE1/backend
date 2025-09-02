<?php

namespace App\Controller\User;

use App\Services\DeleteUser\DeleteUserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeleteUserController extends AbstractController
{
    #[Route('user/delete/{id}', name: 'delete_user', methods: ['DELETE'])]
    public function __invoke(
        int $id,
        DeleteUserServiceInterface $userService,
    ): JsonResponse {
        try {
            return $userService->deleteUserById($id);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Delete Error',
            ]);
        }
    }
}
