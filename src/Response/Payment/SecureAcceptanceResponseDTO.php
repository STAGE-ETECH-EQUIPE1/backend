<?php

namespace App\Response\Payment;

use App\Utils\String\StringTransformer;

class SecureAcceptanceResponseDTO
{
    private string $utf8;
    private string $reqCardNumber;
    private string $reqLocale;
    private string $reqPayerAuthenticationIndicator;
    private string $payerAuthenticationAcsTransactionId;
    private string $signature;
    private string $reqCardTypeSelectionIndicator;
    private string $payerAuthenticationEnrollVeresEnrolled;
    private string $reqBillToSurname;
    private string $reqBillToAddressCity;
    private string $reqCardExpiryDate;
    private string $reqBillToAddressPostalCode;
    private string $reqBillToPhone;
    private string $cardTypeName;
    private string $reasonCode;
    private string $reqBillToForename;
    private string $reqPayerAuthenticationAcsWindowSize;
    private string $reqPaymentMethod;
    private string $requestToken;
    private string $reqPayerAuthenticationMerchantName;
    private string $reqAmount;
    private string $reqBillToEmail;
    private string $payerAuthenticationReasonCode;
    private string $payerAuthenticationEnrollECommerceIndicator;
    private string $transactionId;
    private string $reqCurrency;
    private string $reqCardType;
    private string $payerAuthenticationTransactionId;
    private string $payerAuthenticationParesStatus;
    private string $decision;
    private string $payerAuthenticationCavv;
    private string $reqCustomerIpAddress;
    private string $reqMerchantDefinedData1;
    private string $message;
    private string $signedFieldNames;
    private string $reqTransactionUuid;
    private string $payerAuthenticationEci;
    private string $reqBillToCompanyName;
    private string $payerAuthenticationSpecificationVersion;
    private string $reqBillToAddressCountry;
    private string $reqTransactionType;
    private string $payerAuthenticationXid;
    private string $reqAccessKey;
    private string $reqProfileId;
    private string $reqReferenceNumber;
    private string $payerAuthenticationValidateResult;
    private string $reqBillToAddressState;
    private string $signedDateTime;
    private string $reqBillToAddressLine1;

    public function fromArray(array $data): self
    {
        foreach ($data as $key => $value) {
            $camelKey = StringTransformer::snakeToCamel($key);
            if (property_exists($this, $camelKey)) {
                $this->$camelKey = $value;
            }
        }

        return $this;
    }

    /**
     * Get the value of reqBillToAddressLine1.
     */
    public function getReqBillToAddressLine1(): string
    {
        return $this->reqBillToAddressLine1;
    }

    /**
     * Get the value of utf8.
     */
    public function getUtf8(): string
    {
        return $this->utf8;
    }

    /**
     * Get the value of reqCardNumber.
     */
    public function getReqCardNumber(): string
    {
        return $this->reqCardNumber;
    }

    /**
     * Get the value of reqLocale.
     */
    public function getReqLocale(): string
    {
        return $this->reqLocale;
    }

    /**
     * Get the value of reqPayerAuthenticationIndicator.
     */
    public function getReqPayerAuthenticationIndicator(): string
    {
        return $this->reqPayerAuthenticationIndicator;
    }

    /**
     * Get the value of payerAuthenticationAcsTransactionId.
     */
    public function getPayerAuthenticationAcsTransactionId(): string
    {
        return $this->payerAuthenticationAcsTransactionId;
    }

    /**
     * Get the value of signature.
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * Get the value of reqCardTypeSelectionIndicator.
     */
    public function getReqCardTypeSelectionIndicator(): string
    {
        return $this->reqCardTypeSelectionIndicator;
    }

    /**
     * Get the value of payerAuthenticationEnrollVeresEnrolled.
     */
    public function getPayerAuthenticationEnrollVeresEnrolled(): string
    {
        return $this->payerAuthenticationEnrollVeresEnrolled;
    }

    /**
     * Get the value of reqBillToSurname.
     */
    public function getReqBillToSurname(): string
    {
        return $this->reqBillToSurname;
    }

    /**
     * Get the value of reqBillToAddressCity.
     */
    public function getReqBillToAddressCity(): string
    {
        return $this->reqBillToAddressCity;
    }

    /**
     * Get the value of reqCardExpiryDate.
     */
    public function getReqCardExpiryDate(): string
    {
        return $this->reqCardExpiryDate;
    }

    /**
     * Get the value of reqBillToAddressPostalCode.
     */
    public function getReqBillToAddressPostalCode(): string
    {
        return $this->reqBillToAddressPostalCode;
    }

    /**
     * Get the value of reqBillToPhone.
     */
    public function getReqBillToPhone(): string
    {
        return $this->reqBillToPhone;
    }

    /**
     * Get the value of cardTypeName.
     */
    public function getCardTypeName(): string
    {
        return $this->cardTypeName;
    }

    /**
     * Get the value of reasonCode.
     */
    public function getReasonCode(): string
    {
        return $this->reasonCode;
    }

    /**
     * Get the value of reqBillToForename.
     */
    public function getReqBillToForename(): string
    {
        return $this->reqBillToForename;
    }

    /**
     * Get the value of reqPayerAuthenticationAcsWindowSize.
     */
    public function getReqPayerAuthenticationAcsWindowSize(): string
    {
        return $this->reqPayerAuthenticationAcsWindowSize;
    }

    /**
     * Get the value of reqPaymentMethod.
     */
    public function getReqPaymentMethod(): string
    {
        return $this->reqPaymentMethod;
    }

    /**
     * Get the value of requestToken.
     */
    public function getRequestToken(): string
    {
        return $this->requestToken;
    }

    /**
     * Get the value of reqPayerAuthenticationMerchantName.
     */
    public function getReqPayerAuthenticationMerchantName(): string
    {
        return $this->reqPayerAuthenticationMerchantName;
    }

    /**
     * Get the value of reqAmount.
     */
    public function getReqAmount(): string
    {
        return $this->reqAmount;
    }

    /**
     * Get the value of reqBillToEmail.
     */
    public function getReqBillToEmail(): string
    {
        return $this->reqBillToEmail;
    }

    /**
     * Get the value of payerAuthenticationReasonCode.
     */
    public function getPayerAuthenticationReasonCode(): string
    {
        return $this->payerAuthenticationReasonCode;
    }

    /**
     * Get the value of payerAuthenticationEnrollECommerceIndicator.
     */
    public function getPayerAuthenticationEnrollECommerceIndicator(): string
    {
        return $this->payerAuthenticationEnrollECommerceIndicator;
    }

    /**
     * Get the value of transactionId.
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * Get the value of reqCurrency.
     */
    public function getReqCurrency(): string
    {
        return $this->reqCurrency;
    }

    /**
     * Get the value of reqCardType.
     */
    public function getReqCardType(): string
    {
        return $this->reqCardType;
    }

    /**
     * Get the value of payerAuthenticationTransactionId.
     */
    public function getPayerAuthenticationTransactionId(): string
    {
        return $this->payerAuthenticationTransactionId;
    }

    /**
     * Get the value of payerAuthenticationParesStatus.
     */
    public function getPayerAuthenticationParesStatus(): string
    {
        return $this->payerAuthenticationParesStatus;
    }

    /**
     * Get the value of decision.
     */
    public function getDecision(): string
    {
        return $this->decision;
    }

    /**
     * Get the value of payerAuthenticationCavv.
     */
    public function getPayerAuthenticationCavv(): string
    {
        return $this->payerAuthenticationCavv;
    }

    /**
     * Get the value of reqCustomerIpAddress.
     */
    public function getReqCustomerIpAddress(): string
    {
        return $this->reqCustomerIpAddress;
    }

    /**
     * Get the value of reqMerchantDefinedData1.
     */
    public function getReqMerchantDefinedData1(): string
    {
        return $this->reqMerchantDefinedData1;
    }

    /**
     * Get the value of message.
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get the value of signedFieldNames.
     */
    public function getSignedFieldNames(): string
    {
        return $this->signedFieldNames;
    }

    /**
     * Get the value of reqTransactionUuid.
     */
    public function getReqTransactionUuid(): string
    {
        return $this->reqTransactionUuid;
    }

    /**
     * Get the value of payerAuthenticationEci.
     */
    public function getPayerAuthenticationEci(): string
    {
        return $this->payerAuthenticationEci;
    }

    /**
     * Get the value of reqBillToCompanyName.
     */
    public function getReqBillToCompanyName(): string
    {
        return $this->reqBillToCompanyName;
    }

    /**
     * Get the value of payerAuthenticationSpecificationVersion.
     */
    public function getPayerAuthenticationSpecificationVersion(): string
    {
        return $this->payerAuthenticationSpecificationVersion;
    }

    /**
     * Get the value of reqBillToAddressCountry.
     */
    public function getReqBillToAddressCountry(): string
    {
        return $this->reqBillToAddressCountry;
    }

    /**
     * Get the value of reqTransactionType.
     */
    public function getReqTransactionType(): string
    {
        return $this->reqTransactionType;
    }

    /**
     * Get the value of payerAuthenticationXid.
     */
    public function getPayerAuthenticationXid(): string
    {
        return $this->payerAuthenticationXid;
    }

    /**
     * Get the value of reqAccessKey.
     */
    public function getReqAccessKey(): string
    {
        return $this->reqAccessKey;
    }

    /**
     * Get the value of reqProfileId.
     */
    public function getReqProfileId(): string
    {
        return $this->reqProfileId;
    }

    /**
     * Get the value of reqReferenceNumber.
     */
    public function getReqReferenceNumber(): string
    {
        return $this->reqReferenceNumber;
    }

    /**
     * Get the value of payerAuthenticationValidateResult.
     */
    public function getPayerAuthenticationValidateResult(): string
    {
        return $this->payerAuthenticationValidateResult;
    }

    /**
     * Get the value of reqBillToAddressState.
     */
    public function getReqBillToAddressState(): string
    {
        return $this->reqBillToAddressState;
    }

    /**
     * Get the value of signedDateTime.
     */
    public function getSignedDateTime(): string
    {
        return $this->signedDateTime;
    }
}
