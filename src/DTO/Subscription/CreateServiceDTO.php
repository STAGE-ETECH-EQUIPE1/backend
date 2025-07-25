<?php

namespace App\DTO\Subscription;

use Symfony\Component\Validator\Constraints as Assert;

class CreateServiceDTO
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $price;

    // Type Service
}
