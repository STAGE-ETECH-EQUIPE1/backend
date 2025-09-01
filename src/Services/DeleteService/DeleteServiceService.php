<?php

namespace App\Services\DeleteService;

use App\Repository\Subscription\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteServiceService implements DeleteServiceServiceInterface
{
    public function __construct(
        private ServiceRepository $serviceRepository,
        private EntityManagerInterface $em,
    ){}

    public function deleteServiceById(int $id): JsonResponse
    {
        $service = $this->serviceRepository->find($id);

        if (!$service)
            throw  new \Exception();

        $date = new \DateTimeImmutable();
        $service->setDeleteAt($date);

        $this->em->flush();
        
        return new JsonResponse([
            'message' => 'Delete service success',
            'serviceId' => $service->getId(),
        ]);
    }
}