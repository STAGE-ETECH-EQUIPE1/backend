<?php

namespace App\Services\Subscription;

use App\DTO\Subscription\CreatePackDTO;
use App\Entity\Subscription\Pack;

class CreatePackService
{
    public function createPackFormDTO(CreatePackDTO $dto) // Error : Pack
    {
        $pack = new Pack;

        $pack->setName($dto->name);
        // tous les restes
    }
}