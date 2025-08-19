<?php

namespace App\Request\Payment;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

final class CardInfo
{
    #[Assert\NotBlank]
    #[Assert\Luhn]
    #[Assert\Length(
        min: 12,
        max: 19,
    )]
    private string $number;

    #[Assert\NotBlank]
    #[Assert\Range(
        min: 1,
        max: 12,
    )]
    private string $expMonth;

    #[Assert\NotBlank]
    #[Assert\Range(
        min: 2023,
        max: 2100,
    )]
    private string $expYear;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 3,
        max: 4,
    )]
    private string $cvv;

    public function __construct(Request $request)
    {
        $content = $request->toArray()['card'];
        $this->number = $content['number'] ?? 0;
        $this->expMonth = $content['expMonth'] ?? 0;
        $this->expYear = $content['expYear'] ?? 2000;
        $this->cvv = $content['cvv'] ?? 0;
    }

    /**
     * Get the value of cvv.
     */
    public function getCvv(): string
    {
        return $this->cvv;
    }

    /**
     * Get the value of expYear.
     */
    public function getExpYear(): string
    {
        return $this->expYear;
    }

    /**
     * Get the value of expMonth.
     */
    public function getExpMonth(): string
    {
        return $this->expMonth;
    }

    /**
     * Get the value of number.
     */
    public function getNumber(): string
    {
        return $this->number;
    }
}
