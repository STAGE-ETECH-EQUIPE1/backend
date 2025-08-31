<?php

namespace App\Request\Auth;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationRequest
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

    #[Assert\NotBlank()]
    private string $companyName = '';

    #[Assert\NotBlank()]
    private string $companyArea = '';

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->email = $content['email'] ?? '';
        $this->phone = $content['phone'] ?? '';
        $this->fullName = $content['fullName'] ?? '';
        $this->username = $content['username'] ?? '';
        $this->password = $content['password'] ?? '';
        $this->confirmPassword = $content['confirmPassword'] ?? '';
        $this->companyName = $content['companyName'] ?? '';
        $this->companyArea = $content['companyArea'] ?? '';
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function getCompanyArea(): string
    {
        return $this->companyArea;
    }
}
