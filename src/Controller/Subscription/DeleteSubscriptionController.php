<?php

namespace App\Controller\Subscription;

use App\Services\DeleteSubscription\DeleteSubscriptionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeleteSubscriptionController extends AbstractController
{
    public function __construct(
        private DeleteSubscriptionServiceInterface $subscriptionService,
    ) {
    }

    #[Route('/subscription/delete/{id}', name: 'delete_subscription', methods: ['DELETE'])]
    public function __invoke(
        int $id,
    ): JsonResponse {
        try {
            return $this->subscriptionService->deleteSubscriptionById($id);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Delete Error',
            ]);
        }
    }
}
