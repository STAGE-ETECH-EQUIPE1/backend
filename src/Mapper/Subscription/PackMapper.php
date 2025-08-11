<?php

namespace App\Mapper\Subscription;

use App\DTO\Subscription\PackDTO;
use App\Request\Subscription\PackRequest;

class PackMapper
{
    public static function fromRequest(PackRequest $request): PackDTO
    {
        return new PackDTO(
            $request->name,
            $request->startedAt,
            $request->expiredAt,
            $request->price,
            $request->services
        );
    }
}
