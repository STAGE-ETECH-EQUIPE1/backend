<?php

namespace App\Controller\Subscription;

use App\Response\Subscription\TokensResponse;
use App\Services\TokenManager\TokenManagerServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetAllTokensForServiceController extends AbstractController
{
    public function __construct(
        private readonly TokenManagerServiceInterface $tokenManagerService,
    ) {
    }

    #[Route(
        path: '/tokens/all',
        methods: ['GET'],
        name: 'tokens_all'
    )]
    public function __invoke(): JsonResponse
    {
        $tokenResponse = $this->tokenManagerService->getAllTokens();

        return $this->json([
            'message' => 'All Tokens Service',
            'success' => true,
            'data' => new TokensResponse($tokenResponse),
        ]);
    }
}
