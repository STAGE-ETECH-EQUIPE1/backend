<?php

namespace App\Services\editService;

use App\DTO\Subscription\ServiceDTO;
use App\Entity\Subscription\Service;

interface editServiceServiceInterface
{
    public function handle(int $id, ServiceDTO $dto): ?Service;
}