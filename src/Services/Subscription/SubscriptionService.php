<?php

namespace App\Services\Subscription;

use App\DTO\Subscription\SubscriptionDTO;
use App\Entity\Subscription\Subscription;

class SubscriptionService implements SubscriptionServiceInterface
{
    public function generateSubscription(SubscriptionDTO $subscriptionDTO): Subscription
    {
        $subscription = new Subscription;

        // logique Metier
        
        return $subscription;
    }
}