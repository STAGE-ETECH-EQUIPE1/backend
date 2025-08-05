<?php

namespace App\DTO\Subscription;

use Symfony\Component\Validator\Constraints as Assert;

class SubscriptionDTO
{
    public ?string $reference;

    // Status

    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeImmutable::class)]
    public \DateTimeImmutable $startedAt;

    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeImmutable::class)]
    public \DateTimeImmutable $endedAt;

    // Payment
    
    #[Assert\NotBlank]
    #[Assert\All([
        new Assert\Type('integer'),
    ])]
    /** @var int[] */
    public array $services;
}