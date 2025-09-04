<?php

namespace App\Controller\User;

use App\Response\Subscription\SubscriptionResponse;
use App\Services\Client\ClientServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GetSubscriptionOfCurrentClient extends AbstractController
{
    public function __construct(
        private readonly ClientServiceInterface $clientService,
    ) {
    }

    #[Route(
        path: '/client/subscription',
        name: 'client_get_subscription',
        methods: ['GET']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(): JsonResponse
    {
        $subscription = $this->clientService->getSubscriptionForConnectedClient();
        // dd($subscription);
        if ($subscription) {
            return $this->json([
                'success' => true,
                'message' => 'Current client\'s subscription',
                'data' => new SubscriptionResponse($subscription),
            ], Response::HTTP_OK);
        }

        return $this->json([
            'success' => true,
            'message' => 'The Client has no subscription',
            'data' => null,
        ], Response::HTTP_OK);
    }
}
