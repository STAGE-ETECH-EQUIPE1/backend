<?php

namespace App\Controller\Subscription;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetPackByIdController extends AbstractController
{
    #[Route(
        path: '/packs/{id}',
        name: 'packs_get_id',
        methods: ['GET']
    )]
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'success' => true,
        ]);
    }
}
