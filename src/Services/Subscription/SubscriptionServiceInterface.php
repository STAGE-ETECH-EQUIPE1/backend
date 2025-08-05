<?php

namespace App\Services\Subscription;

use App\DTO\Subscription\SubscriptionDTO;
use App\Entity\Subscription\Subscription;

interface SubscriptionServiceInterface
{
    public function generateSubscription(SubscriptionDTO $subscriptionDTO): Subscription;
}