<?php

namespace App\Request\Subscription;

use Symfony\Component\Validator\Constraints as Assert;

class PackDTO
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
    #[Assert\Regex(
        pattern: '/^\d{1,8}(\.\d{1,2})?$/',
        message: 'Le prix doit contenir au maximum 8 chiffres avant la virgule et 2 après.'
    )]
    public string $price;

    #[Assert\NotBlank]
    #[Assert\All([
        new Assert\Type('integer'),
    ])]
    /** @var int[] */
    public array $services;
}
