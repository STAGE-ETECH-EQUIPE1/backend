<?php

namespace App\Controller\Pack;

use App\Services\DeletePack\DeletePackServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeletePackController extends AbstractController
{
    public function __construct(
        private DeletePackServiceInterface $packService,
    )
    {}

    #[Route('/pack/delete/{id}', name: 'delete_pack', methods: ['DELETE'])]
    public function __invoke(
        int $id,
    ): JsonResponse
    {
        try 
        {
            return $this->packService->deletePackById($id);
        }
        catch (\Exception $e)
        {
            return $this->json([
                'error' => 'Delete Error',
            ]);
        }
    }
}