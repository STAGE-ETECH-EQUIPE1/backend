<?php

namespace App\Services\Payment\MainPayment;

use App\Entity\Payment\Payment;
use App\Response\Payment\SecureAcceptanceResponseDTO;

interface MainPaymentServiceInterface
{
    /**
     * Save payement that have been processed.
     */
    public function savePaymentFromResponseDTO(SecureAcceptanceResponseDTO $response): Payment;
}
