<?php

namespace App\Request\Subscription;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class PackRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type('string', message: 'NOT_VALID_FIELD_VALIDATION')]
    private string $name;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type(\DateTimeInterface::class)]
    private \DateTimeImmutable $startedAt;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type(\DateTimeInterface::class)]
    private \DateTimeImmutable $expiredAt;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Regex(
        pattern: '/^\d{1,8}(\.\d{1,2})?$/',
        message: 'NOT_VALID_FIELD_VALIDATION'
    )]
    private string $price;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\All([
        new Assert\Type('integer', message: 'NOT_VALID_FIELD_VALIDATION'),
    ])]
    /** @var int[] */
    private array $services;

    public function __construct(Request $request)
    {
        $array = $request->toArray();
        $this->name = $array['name'] ?? null;
        $this->startedAt = isset($array['startedAt']) ? new \DateTimeImmutable($array['startedAt']) : new \DateTimeImmutable();
        $this->expiredAt = isset($array['expiredAt']) ? new \DateTimeImmutable($array['expiredAt']) : new \DateTimeImmutable();
        $this->price = $array['price'] ?? null;
        $this->services = $array['services'] ?? null;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getStartedAt(): \DateTimeImmutable
    {
        return $this->startedAt;
    }

    public function getExpiredAt(): \DateTimeImmutable
    {
        return $this->expiredAt;
    }

    public function getServices(): array
    {
        return $this->services;
    }
}
