<?php

namespace App\Request\Subscription;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\SubscriptionStatus;

class SubscriptionRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $reference;

    #[Assert\NotBlank]
    private SubscriptionStatus $status;

    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeImmutable::class)]
    private \DateTimeImmutable $startedAt;
    
    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeImmutable::class)]
    private \DateTimeImmutable $endedAt;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    private int $paymentId;

    #[Assert\NotBlank]
    #[Assert\All([
        new Assert\Type('integer'),
    ])]
    /** @var int[] */
    private array $services;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    private int $clientId;

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->reference = $content['reference'] ?? null;
        $this->status = isset($content['status']) && SubscriptionStatus::tryFrom($content['status'])
        ? SubscriptionStatus::from($content['status'])
        : throw new \InvalidArgumentException("Invalid subscription status: {$content['status']}");
        $this->startedAt = isset($content['startedAt']) ? new \DateTimeImmutable($content['startedAt']) : new \DateTimeImmutable();
        $this->endedAt = isset($content['endedAt']) ? new \DateTimeImmutable($content['endedAt']) : new \DateTimeImmutable();
        $this->paymentId = isset($content['paymentId']) ? (int) $content['paymentId'] : 0;
        $this->services = $content['services'] ?? [];
        $this->clientId = isset($content['clientId']) ? (int) $content['clientId'] : 0;

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

    public function getServices(): array
    {
        return $this->services;
    }

    public function getClientId(): int
    {
        return $this->clientId;
    }
}