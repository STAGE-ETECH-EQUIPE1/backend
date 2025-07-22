<?php

namespace App\DTO;

class ClientDTO
{
    private int $id;

    private string $email;

    private string $username;

    private ?string $phone = null;

    private ?string $fullName = null;

    private \DateTimeImmutable $createdAt;

    private bool $isVerified;

    private string $companyName;

    /**
     * Get the value of id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id.
     */
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

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

    /**
     * Get the value of username.
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username.
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of phone.
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set the value of phone.
     */
    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of fullName.
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * Set the value of fullName.
     */
    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get the value of createdAt.
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt.
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of isVerified.
     */
    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * Set the value of isVerified.
     */
    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * Get Company Name.
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * Set Company Name for the client.
     */
    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }
}
