<?php

namespace App\Services\CreatePack;

use App\DTO\Subscription\CreatePackDTO;
use App\Entity\Subscription\Pack;

interface CreatePackServiceInterface
{
    public function createFormDTO(CreatePackDTO $dto): Pack;
}