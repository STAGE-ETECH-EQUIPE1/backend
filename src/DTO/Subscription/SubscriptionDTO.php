<?php

namespace App\DTO\Subscription;

use App\Enum\SubscriptionStatus;

class SubscriptionDTO
{
    private string $name;
    private string $reference;
    private SubscriptionStatus $status;
    private \DateTimeImmutable $startedAt;
    private \DateTimeImmutable $endedAt;
    private int $paymentId;
    private int $packId;

    /** @var int[] */
    private array $services;
    private int $clientId;

    public function __construct(
        string $name,
        string $reference,
        SubscriptionStatus $status,
        \DateTimeImmutable $startedAt,
        \DateTimeImmutable $endedAt,
        int $paymentId,
        int $packId,
        array $services,
        int $clientId,
    ) {
        $this->name = $name;
        $this->reference = $reference;
        $this->status = $status;
        $this->startedAt = $startedAt;
        $this->endedAt = $endedAt;
        $this->paymentId = $paymentId;
        $this->packId = $packId;
        $this->services = $services;
        $this->clientId = $clientId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function getStatus(): SubscriptionStatus
    {
        return $this->status;
    }

    public function getStartedAt(): \DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function getEndedAt(): \DateTimeImmutable
    {
        return $this->endedAt;
    }

    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    public function getPackId(): int
    {
        return $this->packId;
    }

    /** @return int[] */
    public function getServices(): array
    {
        return $this->services;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }
}
