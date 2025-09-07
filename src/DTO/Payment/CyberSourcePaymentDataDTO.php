<?php

namespace App\DTO\Payment;

class CyberSourcePaymentDataDTO
{
    public function __construct(
        public string $amount,
        public string $currency = 'MGA',
        public string $transactionType = 'authorization',
        public string $locale = 'fr',
        public string $paymentMethod = 'card',
        public ?string $transactionUuid = null,
        public ?string $referenceNumber = null,

        // Informations de facturation
        public ?string $billToForename = null,
        public ?string $billToSurname = null,
        public ?string $billToCompanyName = null,
        public ?string $billToEmail = null,
        public ?string $billToAddressLine1 = null,
        public ?string $billToAddressCity = null,
        public ?string $billToAddressPostalCode = null,
        public string $billToAddressCountry = 'FR',
        public string $billToAddressState = 'FR',
        public ?string $billToPhone = null,
        public ?string $billToZip = null,

        // Champs optionnels
        public string $merchantDefinedData1 = 'iframe_integration',
    ) {
    }

    /**
     * Convertit le DTO en tableau pour l'API CyberSource.
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
            'transaction_type' => $this->transactionType,
            'locale' => $this->locale,
            'payment_method' => $this->paymentMethod,
            'transaction_uuid' => $this->transactionUuid,
            'reference_number' => $this->referenceNumber,
            'bill_to_forename' => $this->billToForename,
            'bill_to_surname' => $this->billToSurname,
            'bill_to_company_name' => $this->billToCompanyName,
            'bill_to_email' => $this->billToEmail,
            'bill_to_address_line1' => $this->billToAddressLine1,
            'bill_to_address_state' => $this->billToAddressState,
            'bill_to_address_city' => $this->billToAddressCity,
            'bill_to_address_postal_code' => $this->billToAddressPostalCode,
            'bill_to_address_country' => $this->billToAddressCountry,
            'bill_to_phone' => $this->billToPhone,
            'bill_to_zip' => $this->billToZip,
            'merchant_defined_data1' => $this->merchantDefinedData1,
        ];
    }

    /**
     * Formate le montant avec 2 décimales.
     */
    public function getFormattedAmount(): string
    {
        return number_format((float) $this->amount, 2, '.', '');
    }

    /**
     * Génère un UUID de transaction si non fourni.
     */
    public function getTransactionUuid(): string
    {
        return $this->transactionUuid ?? uniqid('cs_', true);
    }

    /**
     * Génère un numéro de référence si non fourni.
     */
    public function getReferenceNumber(): string
    {
        return $this->referenceNumber ?? $this->getTransactionUuid();
    }
}
