<?php

namespace App\DTO\Subscription;

class ListPackDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $price,
        public \DateTimeImmutable $startedAt,
        public \DateTimeImmutable $expiredAt,
        public array $services)
    {} 
}