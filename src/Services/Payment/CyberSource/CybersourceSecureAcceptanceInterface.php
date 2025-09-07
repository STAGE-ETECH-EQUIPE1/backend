<?php

namespace App\Services\Payment\CyberSource;

use App\DTO\Payment\CyberSourcePaymentDataDTO;
use App\Response\Payment\PaymentResponse;

interface CybersourceSecureAcceptanceInterface
{
    /*
     * Prépare les données de paiement pour CyberSource avec DTO.
     */
    public function preparePaymentData(CyberSourcePaymentDataDTO $paymentDTO): array;

    /**
     * Get payment resume with all parameter given in query parameters.
     */
    public function getPaymentResumeResponsefromArrayQuery(array $query): PaymentResponse;

    /**
     * Build data for payment process that include pack id to get the amount.
     */
    public function buildDataForPaymentProcessWithPackId(int $id): CyberSourcePaymentDataDTO;
}
