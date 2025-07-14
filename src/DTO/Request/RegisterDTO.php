<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class RegisterDTO
{
    #[Assert\Email()]
    #[Assert\NotBlank()]
    public string $email;

    #[Assert\NotBlank()]
    public ?string $phone = null;

    #[Assert\NotBlank()]
    public ?string $fullName = null;

    #[Assert\NotBlank()]
    public ?string $username = null;

    #[Assert\NotBlank()]
    public string $password;

    #[Assert\NotBlank()]
    public ?string $confirmPassword = null;
}
