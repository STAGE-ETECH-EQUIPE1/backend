<?php

namespace App\Services\CreateService;

use App\DTO\Subscription\CreateServiceDTO;
use App\Entity\Subscription\Service;
use App\Repository\Subscription\TypeServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreateServiceService implements CreateServiceServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        // private TypeServiceRepository $typeServiceRepository,
    ) {
    }

    public function createServiceForm(CreateServiceDTO $dto): Service
    {
        $pack = new Service();
        $pack->setName($dto->name);
        $pack->setPrice($dto->price);

        // Ajout Type Service

        $this->em->persist($pack);
        $this->em->flush();

        return $pack;
    }
}
