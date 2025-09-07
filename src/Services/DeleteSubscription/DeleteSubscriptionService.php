<?php

namespace App\Services\DeleteSubscription;

use App\Repository\Subscription\SubscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteSubscriptionService implements DeleteSubscriptionServiceInterface
{
    public function __construct(
        private SubscriptionRepository $subscriptionRepository,
        private EntityManagerInterface $em,
    ) {
    }

    public function deleteSubscriptionById(int $id): JsonResponse
    {
        $subscription = $this->subscriptionRepository->find($id);

        if (!$subscription) {
            throw new \Exception();
        }

        $date = new \DateTimeImmutable();
        $subscription->setDeleteAt($date);

        $this->em->flush();

        return new JsonResponse([
            'message' => 'Delete subscription success',
            'serviceId' => $subscription->getId(),
        ]);
    }
}
