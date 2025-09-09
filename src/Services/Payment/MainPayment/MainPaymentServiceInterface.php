<?php

namespace App\Services\Payment\MainPayment;

use App\Entity\Payment\Payment;
use App\Response\Payment\SecureAcceptanceResponseDTO;

interface MainPaymentServiceInterface
{
    /**
     * Initialize payement that have been processed.
     */
    public function initializePaymentFromResponseDTO(SecureAcceptanceResponseDTO $response): Payment;
}
