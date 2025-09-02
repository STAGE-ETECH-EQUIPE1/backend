<?php

namespace App\Response\Payment;

use App\Entity\Payment\Payment;

class PaymentResponse
{
    private string $id;
    private string $price;
    private string $currency;
    private string $fullName;
    private string $address;
    private string $city;
    private string $postalCode;
    private string $countryCode;
    private string $cardNumber;
    private string $cardType;
    private string $billEmail;
    private string $transactionId;
    private string $decision;
    private string $isRefunded;
    private string $message;

    public function __construct()
    {
    }

    public function fromPayment(Payment $payment): static
    {
        $this->id = (string) $payment->getId();
        $this->price = (string) $payment->getPrice();
        $this->currency = (string) $payment->getCurrency();
        $this->fullName = (string) $payment->getFullName();
        $this->address = (string) $payment->getAddress();
        $this->city = (string) $payment->getCity();
        $this->postalCode = (string) $payment->getPostalCode();
        $this->countryCode = (string) $payment->getCountryCode();
        $this->cardNumber = (string) $payment->getCardNumber();
        $this->cardType = (string) $payment->getCardType();
        $this->billEmail = (string) $payment->getBillEmail();
        $this->transactionId = (string) $payment->getTransactionId();
        $this->decision = (string) $payment->getDecision();
        $this->isRefunded = (string) ($payment->isRefunded() ? 'true' : 'false');
        $this->message = (string) $payment->getMessage();

        return $this;
    }

    /**
     * Get the value of message.
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get the value of isRefunded.
     */
    public function getIsRefunded(): string
    {
        return $this->isRefunded;
    }

    /**
     * Get the value of decision.
     */
    public function getDecision(): string
    {
        return $this->decision;
    }

    /**
     * Get the value of transactionId.
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * Get the value of billEmail.
     */
    public function getBillEmail(): string
    {
        return $this->billEmail;
    }

    /**
     * Get the value of cardType.
     */
    public function getCardType(): string
    {
        return $this->cardType;
    }

    /**
     * Get the value of cardNumber.
     */
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * Get the value of countryCode.
     */
    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    /**
     * Get the value of postalCode.
     */
    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    /**
     * Get the value of city.
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Get the value of address.
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * Get the value of fullName.
     */
    public function getFullName(): string
    {
        return $this->fullName;
    }

    /**
     * Get the value of currency.
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Get the value of price.
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * Get the value of id.
     */
    public function getId(): string
    {
        return $this->id;
    }
}
