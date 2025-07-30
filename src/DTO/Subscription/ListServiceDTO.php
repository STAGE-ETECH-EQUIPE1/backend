<?php

namespace App\DTO\Subscription;

class ListServiceDTO
{
    public function __construct(
        public int $id,
        public string $name,
    ) {
    }
}
