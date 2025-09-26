<?php

namespace App\Controller\Subscription;

use App\Services\TokenManager\TokenManagerServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GetTokenForServiceController extends AbstractController
{
    public function __construct(
        private readonly TokenManagerServiceInterface $tokenManagerService,
    ) {
    }

    #[Route(
        path: '/tokens',
        name: 'token_getter',
        methods: ['GET']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $tokenValue = $this->tokenManagerService->getToken((string) $request->query->get('name', ''));

        return $this->json([
            'message' => 'get Token Number',
            'data' => $tokenValue,
        ]);
    }
}
