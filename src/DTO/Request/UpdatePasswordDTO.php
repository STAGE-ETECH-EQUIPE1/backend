<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UpdatePasswordDTO
{
    #[Assert\NotBlank()]
    private string $currentPassword;

    #[Assert\NotBlank()]
    private string $newPassword;

    #[Assert\NotBlank()]
    #[Assert\EqualTo(propertyPath: 'newPassword')]
    private string $confirmPassword;

    public function getConfirmPassword(): string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): UpdatePasswordDTO
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }

    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    public function setCurrentPassword(string $currentPassword): static
    {
        $this->currentPassword = $currentPassword;

        return $this;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): static
    {
        $this->newPassword = $newPassword;

        return $this;
    }
}
