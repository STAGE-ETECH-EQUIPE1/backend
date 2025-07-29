<?php

namespace App\Services\ListPack;

use App\DTO\Subscription\ListPackDTO;
use App\DTO\Subscription\ListServiceDTO;
use App\Entity\Pack;
use App\Repository\Subscription\PackRepository;

class ListPackService
{
    public function __construct(private PackRepository $packRepository) 
    {}

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAllPacks(): array
    {
        $packs = $this->packRepository->findAll();
        $result = [];

        foreach ($packs as $pack) {
            $services = [];

            foreach ($pack->getServices() as $service) {
                $services[] = [
                    'id' => $service->getId(),
                    'name' => $service->getName()
                ];
            }

            $result[] = [
                'id' => $pack->getId(),
                'name' => $pack->getName(),
                'price' => (string) $pack->getPrice(),
                'services' => $services
            ];
        }
        return $result;
    }
}
