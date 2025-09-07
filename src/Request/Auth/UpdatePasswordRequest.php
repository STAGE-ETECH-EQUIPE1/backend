<?php

namespace App\Request\Auth;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UpdatePasswordRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    private string $currentPassword;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    private string $newPassword;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\EqualTo(propertyPath: 'newPassword', message: 'CONFIRM_NOT_EQUAL_VALIDATION')]
    private string $confirmPassword;

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->currentPassword = $content['currentPassword'] ?? '';
        $this->newPassword = $content['newPassword'] ?? '';
        $this->confirmPassword = $content['confirmPassword'] ?? '';
    }

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
}
