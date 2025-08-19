<?php

namespace App\Services\Subscription;

use App\DTO\Subscription\SubscriptionDTO;
use App\DTO\Subscription\SubscriptionStatus;
use App\Entity\Subscription\Subscription;
use App\Repository\ServiceRepository;
use App\Repository\SubscriptionRepository;

class SubscriptionService implements SubscriptionServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ServiceRepository $serviceRepository,
        private SubscriptionRepository $subscriptionRepository
    ) {}

    public function createSubscription(SubscriptionDTO $subscriptionDTO): Subscription
    {
        $services = $this->serviceRepository->findBy(['id' => $subscriptionDTO->getServices()]);

        $subscription = new Subscription();
        $subscription->setReference($subscriptionDTO->getReference() ?? '');
        $subscription->setStatus($subscriptionDTO->getStatus() ?? SubscriptionStatus::ACTIVE);

        if ($subscriptionDTO->getStartedAt()) {
            $subscription->setStartedAt($subscriptionDTO->getStartedAt());
        }
        if ($subscriptionDTO->getEndedAt()) {
            $subscription->setEndedAt($subscriptionDTO->getEndedAt());
        }

        foreach ($services as $service) {
            $subscription->addService($service);
        }

        $this->subscriptionRepository->save($subscription, true);

        return $subscription;
    }
}
