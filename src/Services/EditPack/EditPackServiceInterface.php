<?php

namespace App\Services\EditPack;

use App\DTO\Subscription\PackDTO;
use App\Entity\Subscription\Pack;

interface EditPackServiceInterface
{
    public function handle(int $id, PackDTO $dto): ?Pack;
}
