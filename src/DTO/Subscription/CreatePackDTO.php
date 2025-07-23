<?php

namespace App\DTO\Subscription;

use Doctrine\DBAL\Types\DecimalType;
use Symfony\Component\Validator\Constraints as Assert;

class CreatePackDTO
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    public string $name;
    
    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeInterface::class)]
    public \DateTimeImmutable $startedAt;

    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeInterface::class)]
    public \DateTimeImmutable $expiredAt;

    #[Assert\NotBlank]
    #[Assert\Type('float')]
    #[Assert\PositiveOrZero]
    public float $price;
}