<?php

namespace App\Controller\Subscription;

use App\DTO\Subscription\ServiceDTO;
use App\Services\CreateService\CreateServiceServiceInterface;
use App\Services\EditService\EditServiceService;
use App\Services\ListService\ListServiceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ServiceController extends AbstractController
{
    private EditServiceService $editServiceService;

    public function __construct(EditServiceService $editServiceService)
    {
        $this->editServiceService = $editServiceService;
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/create', name: 'create_service', methods: ['POST'])]
    public function createService(
        #[MapRequestPayload(validationGroups: ['create'])]
        ServiceDTO $serviceDTO,
        CreateServiceServiceInterface $createServiceService,
    ): JsonResponse {
        try {
            $service = $createServiceService->createServiceForm($serviceDTO);

            return $this->json([
                'message' => 'Service créé',
                'id' => $service->getId(),
            ], 201);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 400);
        }
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/show', name: 'show_service', methods: ['GET'])]
    public function showServices(ListServiceService $listService): JsonResponse
    {
        $services = $listService->getAllServices();

        return $this->json($services);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/edit/{id}', name: 'edit_service', methods: ['PUT'])]
    public function editServices(
        int $id,
        #[MapRequestPayload(validationGroups: ['update'])] ServiceDTO $dto,
    ): JsonResponse {
        $updated = $this->editServiceService->handle($id, $dto);
        if (!$updated) {
            return $this->json(['error' => 'Service not found'], 404);
        }

       return $this->json([
            'message' => 'Update Success',
            'service' => [
                'id' => $updated->getId(),
                'name' => $updated->getName(),
                'price' => $updated->getPrice(),
            ],
        ]);
    }
}
