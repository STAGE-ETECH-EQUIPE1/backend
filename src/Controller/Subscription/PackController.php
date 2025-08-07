<?php

namespace App\Controller\Subscription;

use App\DTO\Subscription\PackDTO;
use App\Services\CreatePack\CreatePackServiceInterface;
use App\Services\EditPack\EditPackService;
use App\Services\ListPack\ListPackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PackController extends AbstractController
{
    private EditPackService $editPackService;

    public function __construct(EditPackService $editPackService)
    {
        $this->editPackService = $editPackService;
    }

    #[IsGranted('ROLE_ADMIN')]
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
                'id' => $pack->getId(),
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/pack/show', name: 'show_pack', methods: ['GET'])]
    public function showPack(ListPackService $listPackService): JsonResponse
    {
        $packsDto = $listPackService->getAllPacks();

        return $this->json($packsDto);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/pack/edit/{id}', name: 'edit_pack', methods: ['PUT'])]
    public function editPack(
        int $id,
        #[MapRequestPayload] PackDTO $dto,
    ): JsonResponse {
        $updated = $this->editPackService->handle($id, $dto);

        if (!$updated) {
            return $this->json(['error' => 'Pack not found'], 404);
        }

        return $this->json([
            'message' => 'Update Success',
            'pack' => [
                'id' => $updated->getId(),
                'name' => $updated->getName(),
                'price' => $updated->getPrice(),
                'startedAt' => $updated->getStartedAt(),
                'expiredAt' => $updated->getExpiredAt(),
                'services' => $updated->getServices(),
            ],
        ]);
    }
}
