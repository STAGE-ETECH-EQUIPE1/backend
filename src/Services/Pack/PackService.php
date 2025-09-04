<?php

namespace App\Services\Pack;

use App\Entity\Subscription\Pack;
use App\Exception\ResourceNotFoundException;
use App\Repository\Subscription\PackRepository;
use App\Response\Subscription\PackResponse;

class PackService implements PackServiceInterface
{
    public function __construct(
        private readonly PackRepository $packRepository,
    ) {
    }

    public function getById(int $id): Pack
    {
        $pack = $this->packRepository->findOneById($id);
        if ($pack) {
            return $pack;
        }

        throw new ResourceNotFoundException('PACK_NOT_FOUND_EXCEPTION');
    }

    public function convertToResponse(Pack $pack): PackResponse
    {
        return new PackResponse($pack);
    }
}
