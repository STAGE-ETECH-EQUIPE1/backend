<?php

namespace App\Response\Subscription;

use App\Entity\Subscription\Pack;

class PackResponse
{
    private int $id;
    private string $name;
    private string $price;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $startedAt;
    private \DateTimeImmutable $expiredAt;

    public function __construct(Pack $pack)
    {
        $this->id = (int) $pack->getId();
        $this->name = (string) $pack->getName();
        $this->price = (string) $pack->getPrice();
        $this->createdAt = $pack->getCreatedAt() ?? new \DateTimeImmutable();
        $this->startedAt = $pack->getStartedAt() ?? new \DateTimeImmutable();
        $this->expiredAt = $pack->getExpiredAt() ?? new \DateTimeImmutable();
    }

    /**
     * Get the value of expiredAt.
     */
    public function getExpiredAt(): \DateTimeImmutable
    {
        return $this->expiredAt;
    }

    /**
     * Get the value of startedAt.
     */
    public function getStartedAt(): \DateTimeImmutable
    {
        return $this->startedAt;
    }

    /**
     * Get the value of createdAt.
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Get the value of price.
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * Get the value of name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of id.
     */
    public function getId(): int
    {
        return $this->id;
    }
}
