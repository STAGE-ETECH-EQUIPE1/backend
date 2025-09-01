<?php

namespace App\Controller\User;

use App\Services\ListUser\ListeUserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GetAllUsersController extends AbstractController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/user/showAll', name: 'show_users', methods: ['GET'])]
    public function __invoke(
        ListeUserServiceInterface $userService): JsonResponse
    {
        $users = $userService->getAllUsers();

        return $this->json($users);
    }
}
