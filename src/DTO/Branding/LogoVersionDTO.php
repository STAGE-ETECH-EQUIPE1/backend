<?php

namespace App\DTO\Branding;

class LogoVersionDTO
{
    private int $id;

    private string $assertUrl;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $approvedAt;

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
     * Get the value of assertUrl.
     */
    public function getAssertUrl(): string
    {
        return $this->assertUrl;
    }

    /**
     * Set the value of assertUrl.
     */
    public function setAssertUrl(string $assertUrl): static
    {
        $this->assertUrl = $assertUrl;

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
     * Get the value of approvedAt.
     */
    public function getApprovedAt(): \DateTimeImmutable
    {
        return $this->approvedAt;
    }

    /**
     * Set the value of approvedAt.
     */
    public function setApprovedAt(\DateTimeImmutable $approvedAt): static
    {
        $this->approvedAt = $approvedAt;

        return $this;
    }
}
