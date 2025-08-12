<?php

namespace App\Request\Subscription;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;

class PackRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeInterface::class)]
    private \DateTimeImmutable $startedAt;

    #[Assert\NotBlank]
    #[Assert\Type(\DateTimeInterface::class)]
    private \DateTimeImmutable $expiredAt;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^\d{1,8}(\.\d{1,2})?$/',
        message: 'Le prix doit contenir au maximum 8 chiffres avant la virgule et 2 après.'
    )]
    private string $price;

    #[Assert\NotBlank]
    #[Assert\All([
        new Assert\Type('integer'),
    ])]
    /** @var int[] */
    private array $services;

    public function __construct(Request $request)
    {
        $array = $request->toArray();
        $this->name = $array['name'] ?? null;
        $this->startedAt = isset($data['startedAt']) ? new \DateTimeImmutable($data['startedAt']) : new \DateTimeImmutable();
        $this->expiredAt = isset($data['expiredAt']) ? new \DateTimeImmutable($data['expiredAt']) : new \DateTimeImmutable();
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
