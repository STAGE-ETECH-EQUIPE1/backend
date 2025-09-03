<?php

namespace App\Services\EditPack;

use App\DTO\Subscription\PackDTO;
use App\Entity\Subscription\Pack;
use App\Repository\Subscription\PackRepository;
use App\Repository\Subscription\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class EditPackService implements EditPackServiceInterface
{
    private PackRepository $packRepository;
    private ServiceRepository $serviceRepository;
    private EntityManagerInterface $em;

    public function __construct(PackRepository $packRepository, ServiceRepository $serviceRepository, EntityManagerInterface $em)
    {
        $this->packRepository = $packRepository;
        $this->serviceRepository = $serviceRepository;
        $this->em = $em;
    }

    public function handle(int $id, PackDTO $dto): ?Pack
    {
        $pack = $this->packRepository->find($id);
        if (!$pack) {
            return null;
        }

        if ($dto->name !== $pack->getName()) {
            $pack->setName($dto->name);
        }

        if ($dto->price !== $pack->getPrice()) {
            $pack->setPrice($dto->price);
        }

        if ($dto->startedAt !== $pack->getStartedAt()) {
            $pack->setStartedAt($dto->startedAt);
        }

        if ($dto->expiredAt !== $pack->getExpiredAt()) {
            $pack->setExpiredAt($dto->expiredAt);
        }

        $currentServices = $pack->getServices();
        $newServiceIds = $dto->services;

        foreach ($currentServices as $Services) {
            if (!in_array($Services->getId(), $newServiceIds)) {
                $pack->removeService($Services);
            }
        }

        $currentServiceIds = array_map(fn ($s) => $s->getId(), $pack->getServices()->toArray());

        if ($dto->services !== $currentServiceIds) {
            foreach ($pack->getServices() as $service) {
                $pack->removeService($service);
            }
            foreach ($dto->services as $serviceId) {
                $service = $this->serviceRepository->find($serviceId);
                if ($service) {
                    $pack->addService($service);
                }
            }
        }

        $this->em->flush();

        return $pack;
    }
}
