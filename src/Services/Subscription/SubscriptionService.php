<?php

namespace App\Services\Subscription;

use App\DTO\Subscription\SubscriptionDTO;
use App\Entity\Subscription\Subscription;

class SubscriptionService implements SubscriptionServiceInterface
{
    public function createSubscription(SubscriptionDTO $subscriptionDTO): Subscription
    {
        // Verif existance Payments
        $services = $this->serviceRepository->findBy(['id' => $subscriptionDTO->servicesIds]);

        $subscription = new Subscription();
        $subscription->setReference($subscriptionDTO->reference);
        $subscription->setStatus($subscriptionDTO->status ?? SubscriptionStatus::ACTIVE);
        $subscription->setStartedAt($subscriptionDTO->startedAt);
        $subscription->setEndedAt($subscriptionDTO->endedAt);

        // $subscription->setPayment($payment);
        foreach ($services as $service) {
            $subscription->addService($service);
        }

        $this->subsciptionRepository->save($subscription, true);

        return $subscription;
    }
}
