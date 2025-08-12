<?php

namespace App\DTO\Subscription;

class SubscriptionDTO
{
    private ?string $reference;
    private ?SubscriptionStatus $status;
    private ?\DateTimeImmutable $startedAt;
    private ?\DateTimeImmutable $endedAt;
    private ?int $paymentId;

    /** @var int[] */
    private array $services;

    public function __construct(
        ?string $reference,
        ?SubscriptionStatus $status,
        ?DateTimeImmutable $startedAt,
        ?DateTimeImmutable $endedAt,
        ?int $paymentId,
        array $services,
    ) {
        $this->reference = $reference;
        $this->status = $status;
        $this->startedAt = $startedAt;
        $this->endedAt = $endedAt;
        $this->payment = $paymentId;
        $this->services = $services;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function getStatus(): ?SubscriptionStatus
    {
        return $this->status;
    }

    public function getStartedAt(): ?\DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function getEndedAt(): ?\DateTimeImmutable
    {
        return $this->endedAt;
    }

    public function getPaymentId(): ?int
    {
        return $this->paymentId;
    }

    /** @return int[] */
    public function getServices(): array
    {
        return $this->services;
    }
}
