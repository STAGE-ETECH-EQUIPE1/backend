<?php

namespace App\Controller\Subscription;

use App\DTO\Subscription\SubscriptionDTO;
use App\Services\Subscription\SubscriptionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SubscriptionController extends AbstractController
{
    // #[IsGranted('ROLE_USER')]
    // #[Route('/pack/subscription', name: 'subscription', methods: ['POST'])]
    // public function createSubscription(
    //     #[MapRequestPayload]
    //     SubscriptionDTO $subscriptionDTO,
    //     SubscriptionServiceInterface $subscriptionServiceInterface,
    // ): JsonResponse {
    //     $subscription = $subscriptionServiceInterface->createSubscription($subscriptionDTO);

    //     return $this->json([
    //         'message' => 'Subscription Success',
    //         'id' => $subscription->getId(),
    //     ]);
    // }
}
