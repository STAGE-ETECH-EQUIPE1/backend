<?php

namespace App\Response\Subscription;

use App\Entity\Subscription\Pack;
use App\Entity\Subscription\Subscription;
use App\Enum\SubscriptionStatus;

class SubscriptionResponse
{
    private int $id;
    private string $reference;
    private string $name;
    private SubscriptionStatus $status;
    private \DateTimeImmutable $createdAt;
    private \DateTimeImmutable $startedAt;
    private \DateTimeImmutable $endedAt;
    private PackResponse $pack;
    private array $services;

    public function __construct(Subscription $subscription)
    {
        /** @var Pack $pack */
        $pack = $subscription->getPack();

        $this->id = (int) $subscription->getId();
        $this->reference = (string) $subscription->getReference();
        $this->name = (string) $subscription->getName();
        $this->status = $subscription->getStatus() ?? SubscriptionStatus::CANCELED;
        $this->pack = new PackResponse($pack);
        $this->createdAt = $subscription->getCreatedAt() ?? new \DateTimeImmutable();
        $this->startedAt = $subscription->getStartedAt() ?? new \DateTimeImmutable();
        $this->endedAt = $subscription->getEndedAt() ?? new \DateTimeImmutable();
        $this->services = array_map(
            fn ($service): ServiceResponse => new ServiceResponse($service),
            $subscription->getServices()->getValues()
        );
    }

    /**
     * Get the value of id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of reference.
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * Get the value of name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of status.
     */
    public function getStatus(): SubscriptionStatus
    {
        return $this->status;
    }

    /**
     * Get the value of createdAt.
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Get the value of startedAt.
     */
    public function getStartedAt(): \DateTimeImmutable
    {
        return $this->startedAt;
    }

    /**
     * Get the value of endedAt.
     */
    public function getEndedAt(): \DateTimeImmutable
    {
        return $this->endedAt;
    }

    /**
     * Get the value of pack.
     */
    public function getPack(): PackResponse
    {
        return $this->pack;
    }

    /**
     * Get the value of services.
     */
    public function getServices(): array
    {
        return $this->services;
    }
}
