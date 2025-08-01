<?php

namespace App\Services\EditService;

use App\DTO\Subscription\ServiceDTO;
use App\Entity\Subscription\Service;

interface EditServiceServiceInterface
{
    public function handle(int $id, ServiceDTO $dto): ?Service;
}
