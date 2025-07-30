<?php

namespace App\DTO\Subscription;

use Symfony\Component\Validator\Constraints as Assert;

class CreateServiceDTO
{
    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^\d{1,8}(\.\d{1,2})?$/',
        message: 'Le prix doit contenir au maximum 8 chiffres avant la virgule et 2 après.'
    )]
    public string $price;
}
