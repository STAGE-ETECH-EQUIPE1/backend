<?php

namespace App\Services\Payment\CyberSource;

use App\DTO\Payment\CyberSourcePaymentDataDTO;

interface CybersourceSecureAcceptanceInterface
{
    /*
     * Prépare les données de paiement pour CyberSource avec DTO
     */
    public function preparePaymentData(CyberSourcePaymentDataDTO $paymentDTO): array;
}
