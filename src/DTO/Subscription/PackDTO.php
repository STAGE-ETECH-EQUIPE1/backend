<?php

namespace App\DTO\Subscription;

use Symfony\Component\Validator\Constraints as Assert;

class PackDTO
{
    public string $name;
    public \DateTimeImmutable $startedAt;
    public \DateTimeImmutable $expiredAt;
    public string $price;

    /** @var int[] */
    public array $services;

    public function __construct(
        string $name,
        \DateTimeImmutable $startedAt,
        \DateTimeImmutable $expiredAt,
        string $price,
        array $services,
    ){
        $this->name = $name;
        $this->startedAt = $startedAt;
        $this->expiredAt = $expiredAt;
        $this->price = $price;
        $this->services = $services;
    }

    public function getName(): string 
    {
        return $this->name;
    }

    public function getStartedAt(): \DateTimeImmutable 
    {
        return $this->startedAt;
    }

    public function getExpiredAt(): \DateTimeImmutable 
    {
        return $this->expiredAt;
    }

    public function getPrice(): string 
    {
        return $this->price;
    }

    /** @var int[] */
    public function getServices(): array 
    {
        return $this->services;
    }

}
