<?php

namespace App\DTO\Subscription;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

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

    public function getToken(): string 
    {
        return $this->token;
    }
}
