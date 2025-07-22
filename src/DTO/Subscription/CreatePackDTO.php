<?php

namespace App\DTO\Subscription;

use Symfony\Component\Validator\Constraints as Assert;

class CreatePackDTO
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $name;
    
    
}