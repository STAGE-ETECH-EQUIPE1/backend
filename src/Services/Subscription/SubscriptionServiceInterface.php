<?php

namespace App\Services\Subscription;

use App\DTO\Payment\CyberSourcePaymentDataDTO;
use App\DTO\Subscription\SubscriptionDTO;
use App\Entity\Subscription\Pack;
use App\Entity\Subscription\Subscription;
use App\Response\Payment\SecureAcceptanceResponseDTO;

interface SubscriptionServiceInterface
{
    public function createSubscription(SubscriptionDTO $subscriptionDTO): Subscription;

    /**
     * Initialize Subscription after choosing pack and initialize Payment Data.
     */
    public function initializeSubscriptionFromPack(Pack $pack, CyberSourcePaymentDataDTO $cyberSourcePaymentDataDTO): Subscription;

    /**
     * Update Payment Status after payment from Cybersource.
     */
    public function updateSubscriptionAfterPayment(SecureAcceptanceResponseDTO $response): Subscription;
}
