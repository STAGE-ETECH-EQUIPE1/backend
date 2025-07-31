<?php

namespace App\Services\CreateService;

use App\DTO\Subscription\ServiceDTO;
use App\Entity\Subscription\Service;
use Doctrine\ORM\EntityManagerInterface;

class CreateServiceService implements CreateServiceServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {
    }

    public function createServiceForm(ServiceDTO $dto): Service
    {
        $service = new Service();
        $service->setName($dto->name);
        $service->setPrice($dto->price);

        $this->em->persist($service);
        $this->em->flush();

        return $service;
    }
}
