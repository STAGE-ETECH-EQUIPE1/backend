<?php

namespace App\DTO\Subscription;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class ServiceDTO
{
    public string $name;
    public string $price;

    public function __construct(
        string $name,
        string $price,
    ) {
        $this->name = $name;
        $this->price = $price;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getPrice(): string 
    {
        return $this->price;
    }
}
