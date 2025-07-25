<?php

namespace App\Services\CreateService;

use App\DTO\Subscription\CreateServiceDTO;
use App\Entity\Subscription\Service;

interface CreateServiceServiceInterface
{
    public function createServiceForm(CreateServiceDTO $dto): Service;
}
