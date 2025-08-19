<?php

namespace App\Controller\Subscription;

use App\DTO\Subscription\SubscriptionDTO;
use App\Services\Subscription\SubscriptionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SubscriptionController extends AbstractController
{
    private AppValidatorInterface $validator;
    private SubscriptionServiceInterface $subscriptionServiceInterface;

    public function __construct(
        AppValidatorInterface $validator,
        SubscriptionServiceInterface $subscriptionServiceInterface,
    ){
        $this->validator = $validator;
        $this->subscriptionServiceInterface = $subscriptionServiceInterface;
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/pack/subscription', name: 'subscription', methods: ['POST'])]
    public function createSubscription(
        Request $request,
    ): JsonResponse {
        try {
            $subscriptionRequest = new SubscriptionRequest();
            $error = $this->validator->validateRequest($subscriptionRequest);
            if (count($error) > 0)
            {
                return $this->json([
                    'message' => $error,
                ], Response::HTTP_BAD_REQUEST);
            }
            
            $subscriptionDto = SubscriptionMapper::fromRequest($subscriptionRequest);
            $subscription = $this->subscriptionServiceInterface->createSubscription($subscriptionDto);

            return $this->json([
                'message' => 'Subscription Success',
                'id' => $subscription->getId(),
            ]);
        } catch (\Exception $e){
            return $this->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}