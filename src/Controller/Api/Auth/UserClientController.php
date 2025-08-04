<?php

namespace App\Controller\Api\Auth;

use App\Exception\ClientNotAssociedException;
use App\Services\Client\ClientServiceInterface;
use App\Services\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class UserClientController extends AbstractController
{
    public function __construct(
        private readonly ClientServiceInterface $clientService,
        private readonly UserServiceInterface $userService,
    ) {
    }

    #[Route(path: '/client/me', name: 'client_form_connected_user', methods: ['GET'])]
    public function getClientFromUser(): JsonResponse
    {
        try {
            return $this->json([
                'message' => 'Informations about connected client user retrieved successfully.',
                'data' => $this->clientService->convertUserClientToClientDTO($this->userService->getConnectedUser()),
            ]);
        } catch (ClientNotAssociedException $e) {
            return $this->json([
                'message' => 'no client is not associated with the user.',
                'data' => $this->userService->convertToDto($this->userService->getConnectedUser()),
            ]);
        }
    }
}