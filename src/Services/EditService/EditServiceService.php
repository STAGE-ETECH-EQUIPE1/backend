<?php

namespace App\Services\EditService;

use App\DTO\Subscription\ServiceDTO;
use App\Entity\Subscription\Service;
use App\Repository\Subscription\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;

class EditServiceService implements EditServiceServiceInterface
{
    private ServiceRepository $serviceRepository;
    private EntityManagerInterface $em;

    public function __construct(ServiceRepository $serviceRepository, EntityManagerInterface $em)
    {
        $this->serviceRepository = $serviceRepository;
        $this->em = $em;
    }

    public function handle(int $id, ServiceDTO $dto): ?Service
    {
        $service = $this->serviceRepository->find($id);
        if (!$service) {
            return null;
        }

        $service->setName($dto->name);
        $service->setPrice($dto->price);

        $this->em->flush();

        return $service;
    }
}
