<?php

namespace App\Request\Subscription;

use App\Enum\SubscriptionStatus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class SubscriptionRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type('string', message: 'NOT_VALID_FIELD_VALIDATION')]
    private string $reference;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    private SubscriptionStatus $status;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type(type: \DateTimeImmutable::class, message: 'NOT_VALID_DATE_VALIDATION')]
    private \DateTimeImmutable $startedAt;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type(type: \DateTimeImmutable::class, message: 'NOT_VALID_DATE_VALIDATION')]
    private \DateTimeImmutable $endedAt;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type(type: 'integer', message: 'NOT_VALID_FIELD_VALIDATION')]
    private int $paymentId;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\All([
        new Assert\Type('integer', message: 'NOT_VALID_FIELD_VALIDATION'),
    ])]
    /** @var int[] */
    private array $services;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type(type: 'integer', message: 'NOT_VALID_FIELD_VALIDATION')]
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
