<?php

namespace App\Controller\Api\Subscription;

use App\DTO\Subscription\PackDTO;
use App\Services\CreatePack\CreatePackServiceInterface;
use App\Services\ListPack\ListPackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class PackController extends AbstractController
{
    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/pack/create', name: 'create_pack', methods: ['POST'])]
    public function createPack(
        #[MapRequestPayload]
        PackDTO $packDTO,
        CreatePackServiceInterface $createPackService,
    ): JsonResponse {
        try {
            $pack = $createPackService->createPackForm($packDTO);

            return $this->json([
                'message' => 'Pack créé',
                'packId' => $pack->getId(),
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/pack/show', name: 'show_pack', methods: ['GET'])]
    public function showPack(ListPackService $listPackService): JsonResponse
    {
        $packsDto = $listPackService->getAllPacks();

        return $this->json($packsDto);
    }
}
