<?php

namespace App\Response\Subscription;

use App\Entity\Subscription\Service;

class ServiceResponse
{
    private int $id;
    private string $name;
    private string $price;
    private \DateTimeImmutable $createdAt;
    private int $token;

    public function __construct(Service $service)
    {
        $this->id = (int) $service->getId();
        $this->name = (string) $service->getName();
        $this->price = (string) $service->getPrice();
        $this->createdAt = $service->getCreatedAt() ?? new \DateTimeImmutable();
        $this->token = (int) $service->getToken();
    }

    /**
     * Get the value of id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of price.
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * Get the value of createdAt.
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Get the value of token.
     */
    public function getToken(): int
    {
        return $this->token;
    }
}
