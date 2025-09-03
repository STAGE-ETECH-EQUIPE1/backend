<?php

namespace App\Services\CreateService;

use App\DTO\Subscription\ServiceDTO;
use App\Entity\Subscription\Service;

interface CreateServiceServiceInterface
{
    public function createServiceForm(ServiceDTO $dto): Service;
}
