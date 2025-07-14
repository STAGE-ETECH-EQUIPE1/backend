<?php

namespace App\DTO;

final class UserDTO
{
    private int $id;

    private string $email;

    private string $username;

    private ?string $phone = null;

    private ?string $fullName = null;

    private \DateTimeImmutable $createdAt;

    private bool $isVerified;

    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     * @param int $id
     * @return  self
     */
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     * @param string $email
     * @return  self
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     *
     * @return  self
     */
    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of phone
     */
    public function getPhone(): string|null
    {
        return $this->phone;
    }

    /**
     * Set the value of phone
     * @param string $phone
     * @return  self
     */
    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get the value of fullName
     */
    public function getFullName(): string|null
    {
        return $this->fullName;
    }

    /**
     * Set the value of fullName
     * @param string $fullName
     * @return  self
     */
    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     * @param \DateTimeImmutable $createdAt
     * @return  self
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get the value of isVerified
     */
    public function getIsVerified(): bool
    {
        return $this->isVerified;
    }

    /**
     * Set the value of isVerified
     * @param bool $isVerified
     * @return  self
     */
    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
