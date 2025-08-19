<?php

namespace App\Request\Payment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class CyberSourcePaymentRequest
{
    #[Assert\NotBlank]
    #[Assert\Positive]
    private float $amount;

    #[Assert\NotBlank]
    #[Assert\Currency]
    private string $currency;

    #[Assert\NotBlank]
    private string $orderId;

    #[Assert\NotBlank]
    #[Assert\Valid]
    private CardInfo $card;

    #[Assert\NotBlank]
    #[Assert\Valid]
    private BillingInfo $billing;

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->amount = $content['amount'] ?? 0;
        $this->currency = $content['currency'] ?? '';
        $this->orderId = $content['orderId'] ?? '';
        $this->card = new CardInfo($request);
        $this->billing = new BillingInfo($request);
    }

    /**
     * Get the value of billing.
     */
    public function getBilling(): BillingInfo
    {
        return $this->billing;
    }

    /**
     * Get the value of card.
     */
    public function getCard(): CardInfo
    {
        return $this->card;
    }

    /**
     * Get the value of orderId.
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * Get the value of currency.
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Get the value of amount.
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
