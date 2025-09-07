<?php

namespace App\Mapper\Subscription;

use App\DTO\Subscription\PackDTO;
use App\Request\Subscription\PackRequest;

class PackMapper
{
    public static function fromRequest(PackRequest $request): PackDTO
    {
        return new PackDTO(
            $request->getName(),
            $request->getStartedAt(),
            $request->getExpiredAt(),
            $request->getPrice(),
            $request->getServices()
        );
    }
}
