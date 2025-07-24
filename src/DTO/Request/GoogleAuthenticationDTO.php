<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class GoogleAuthenticationDTO
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $idToken;
}
