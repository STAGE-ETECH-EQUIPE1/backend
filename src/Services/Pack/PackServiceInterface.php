<?php

namespace App\Services\Pack;

use App\Entity\Subscription\Pack;
use App\Response\Subscription\PackResponse;

interface PackServiceInterface
{
    /**
     * Get Pack By Id.
     */
    public function getById(int $id): Pack;

    /**
     * Convert Pack to Pack Response.
     */
    public function convertToResponse(Pack $pack): PackResponse;
}
