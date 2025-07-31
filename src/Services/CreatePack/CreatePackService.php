<?php

namespace App\Services\CreatePack;

use App\DTO\Subscription\PackDTO;
use App\Entity\Subscription\Pack;
use App\Repository\Subscription\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class CreatePackService implements CreatePackServiceInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private ServiceRepository $serviceRepository,
    ) {
    }

    public function createPackForm(PackDTO $dto): Pack
    {
        $pack = new Pack();
        $pack->setName($dto->name);
        $pack->setPrice($dto->price);
        $pack->setStartedAt($dto->startedAt);
        $pack->setExpiredAt($dto->expiredAt);

        foreach ($dto->services as $id) {
            $service = $this->serviceRepository->find($id);
            if (!$service) {
                throw new \Exception("Service ID $id introuvable.");
            }
            $pack->addService($service);
        }

        $this->em->persist($pack);
        $this->em->flush();

        return $pack;
    }
}
