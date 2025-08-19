<?php

namespace App\Services\CyberSource;

use App\Request\Payment\CyberSourcePaymentRequest;

interface CyberSourceServiceInterface
{
    /**
     * Process to payment to CyberSource API.
     */
    public function processPayment(CyberSourcePaymentRequest $request): array;
}
