<?php

namespace App\Services\ListService;

use App\Repository\Subscription\ServiceRepository;

class ListServiceService implements ListServiceServiceInterface
{
    public function __construct(private ServiceRepository $serviceRepository)
    {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAllServices(): array
    {
        $services = $this->serviceRepository->findAll();
        $result = [];

        foreach ($services as $service) {
            $result[] = [
                'id' => $service->getId(),
                'name' => $service->getName(),
                'price' => (string) $service->getPrice(),
            ];
        }

        return $result;
    }
}

