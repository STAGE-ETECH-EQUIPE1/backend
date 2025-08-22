<?php

namespace App\DTO\Subscription;

class ServiceDTO
{
    private string $name;
    private string $price;
    private int $token;

    public function __construct(
        string $name,
        string $price,
        int $token,
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->token = $token;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getToken(): int
    {
        return $this->token;
    }
}
