<?php

namespace App\Request\Auth;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Email(message: 'NOT_VALID_EMAIL_VALIDATION')]
    private string $email;

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->email = $content['email'] ?? '';
    }

    /**
     * Get the value of email.
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
