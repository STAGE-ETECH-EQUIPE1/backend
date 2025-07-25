<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordDTO
{
    #[Assert\NotBlank()]
    #[Assert\Email()]
    private string $email;

    /**
     * Get the value of email.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email.
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
