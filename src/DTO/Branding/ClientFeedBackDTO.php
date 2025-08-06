<?php

namespace App\DTO\Branding;

class ClientFeedBackDTO
{
    private int $id;

    private string $comment;

    private \DateTimeImmutable $createdAt;

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
     * Get the value of comment.
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * Set the value of comment.
     */
    public function setComment(string $comment): static
    {
        $this->comment = $comment;

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
}
