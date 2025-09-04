<?php

namespace App\Request\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type('string', message: 'NOT_VALID_FIELD_VALIDATION')]
    private string $email;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type('integer', message: 'NOT_VALID_FIELD_VALIDATION')]
    private int $phone;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type('string', message: 'NOT_VALID_FIELD_VALIDATION')]
    private string $fullName;

    public function __construct(Request $request)
    {
        $array = $request->toArray();
        $this->email = $array['email'] ?? null;
        $this->phone = $array['phone'] ?? 0;
        $this->fullName = $array['fullName'] ?? null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): int
    {
        return $this->phone;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }
}
