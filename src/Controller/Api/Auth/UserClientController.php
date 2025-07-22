<?php

namespace App\Controller\Api\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class UserClientController extends AbstractController
{
    public function __construct(
    ) {
    }

    #[Route(path: '/client/me', name: 'client_form_connected_user', methods: ['GET'])]
    public function getClientFromUser(): JsonResponse
    {
        return $this->json([]);
    }
}
