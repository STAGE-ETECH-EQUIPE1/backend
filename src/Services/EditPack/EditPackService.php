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

        if ($dto->name !== null) {
            $pack->setName($dto->name);
        }

        if ($dto->price !== null) {
            $pack->setPrice($dto->price);
        }

        if ($dto->startedAt !== null) {
            $pack->setStartedAt($dto->startedAt);
        }

        if ($dto->expiredAt !== null) {
            $pack->setExpiredAt($dto->expiredAt);
        }

        if ($dto->services !== null) {
            $currentServices = $pack->getServices();
            $newServiceIds = $dto->services;

            foreach ($currentServices as $Services) {
                if (!in_array($Services->getId(), $newServiceIds)) {
                    $pack->removeService($Services);
                }
            }

            $currentServiceIds = [];
            foreach ($currentServices as $Services) {
                $currentServiceIds[] = $Services->getId();
            }

            foreach ($newServiceIds as $serviceId) {
                if (!in_array($serviceId, $currentServiceIds)) {
                    $service = $this->serviceRepository->find($serviceId);
                    if (!$service) {
                        throw new \Exception("Service ID $serviceId not found");
                    }
                    $pack->addService($service);
                }
            }
        }
        $this->em->flush();

        return $pack;
    }
}
