<?php

namespace App\DTO\Response;

final class JWTUser
{
    public function __construct(
        private string $username,
        private string $email,
        private array $roles,
    ) {
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
}
