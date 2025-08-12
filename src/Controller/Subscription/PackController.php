<?php

namespace App\Controller\Subscription;

use App\DTO\Subscription\PackDTO;
use App\Request\Subscription\PackRequest;
use App\Services\CreatePack\CreatePackServiceInterface;
use App\Services\EditPack\EditPackService;
use App\Services\ListPack\ListPackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Mapper\Subscription\PackMapper;


class PackController extends AbstractController
{
    private EditPackService $editPackService;
    private AppValidatorInterface $validator;
    private CreatePackServiceInterface $createPackService;

    public function __construct(
        EditPackService $editPackService,
        CreatePackServiceInterface $createPackService,
        AppValidatorInterface $validator,
    ){
        $this->editPackService = $editPackService;
        $this->createPackService = $createPackService;
        $this->validator = $validator;
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/pack/create', name: 'create_pack', methods: ['POST'])]
    public function createPack(
        Request $request,
    ): JsonResponse {
        try {

            $request = new PackRequest($request);
            $error = $this->validator->validateRequest($request);
            if (count($error) > 0)
            {
                return $this->json([
                    'error' => $error,
                ], Response::HTTP_BAD_REQUEST);
            }

            $dto = PackMapper::fromRequest($request);
            $pack = $this->createPackService->createPackForm($dto);
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
        Request $request,
    ): JsonResponse {
        $request = new PackRequest($request);

        $errors = $this->validator->validateRequest($request);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }
        $dto = PackMapper::fromRequest($request);
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
