<?php

namespace App\DTO\Branding;

use App\Enum\BrandingStatus;

class BrandingProjectDTO
{
    private int $id;

    private BrandingStatus $status;

    private string $description;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $updatedAt;

    private \DateTimeImmutable $deadLine;

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
     * Get the value of status.
     */
    public function getStatus(): BrandingStatus
    {
        return $this->status;
    }

    /**
     * Set the value of status.
     */
    public function setStatus(BrandingStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get the value of description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description.
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

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
     * Get the value of updatedAt.
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt.
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get the value of deadLine.
     */
    public function getDeadLine(): \DateTimeImmutable
    {
        return $this->deadLine;
    }

    /**
     * Set the value of deadLine.
     */
    public function setDeadLine(\DateTimeImmutable $deadLine): static
    {
        $this->deadLine = $deadLine;

        return $this;
    }
}
