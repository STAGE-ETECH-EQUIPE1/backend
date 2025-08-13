<?php

namespace App\Services\CreatePack;

use App\DTO\Subscription\PackDTO;
use App\Entity\Subscription\Pack;

interface CreatePackServiceInterface
{
    public function createPackForm(PackDTO $dto): Pack;
}
