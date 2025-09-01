<?php

namespace App\Services\DeletePack;

use App\Repository\Subscription\PackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeletePackService implements DeletePackServiceInterface
{
    public function __construct(
        private PackRepository $packRepository,
        private EntityManagerInterface $em,
    ){}

    public function deletePackById(int $id): JsonResponse
    {
        $pack = $this->packRepository->find($id);

        if (!$pack)
            throw  new \Exception();

        $date = new \DateTimeImmutable();
        $pack->setDeleteAt($date);

        $this->em->flush();
        
        return new JsonResponse([
            'message' => 'Delete Pack success',
            'packId' => $pack->getId(),
        ]);
    }
}