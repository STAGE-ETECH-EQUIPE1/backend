<?php

namespace App\Mapper\Subscription;

use App\DTO\Subscription\SubscriptionDTO;
use App\Request\Subscription\SubscriptionRequest;

class SubscriptionMapper
{
    public static function fromRequest(SubscriptionRequest $request): SubscriptionDTO
    {
        return new SubscriptionDTO(
            $request->getReference(),
            $request->getStatus(),
            $request->getStartedAt(),
            $request->getEndedAt(),
            $request->getPaymentId(),
            $request->getServices(),
            $request->getClientId()
        );
    }
}