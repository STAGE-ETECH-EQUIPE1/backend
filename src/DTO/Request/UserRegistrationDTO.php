<?php

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationDTO
{
    #[Assert\Email()]
    #[Assert\NotBlank()]
    private string $email;

    #[Assert\NotBlank()]
    private ?string $phone = null;

    #[Assert\NotBlank()]
    private ?string $fullName = null;

    #[Assert\NotBlank()]
    private ?string $username = null;

    #[Assert\NotBlank()]
    private string $password;

    #[Assert\NotBlank()]
    #[Assert\EqualTo(propertyPath: 'password')]
    private ?string $confirmPassword = null;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserRegistrationDTO
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): UserRegistrationDTO
    {
        $this->phone = $phone;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): UserRegistrationDTO
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): UserRegistrationDTO
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): UserRegistrationDTO
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(?string $confirmPassword): UserRegistrationDTO
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
