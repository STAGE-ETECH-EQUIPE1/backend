<?php

namespace App\Controller\Api\Subscription;

use App\DTO\Subscription\CreateServiceDTO;
use App\Services\CreateService\CreateServiceServiceInterface;
use App\Services\ListService\ListServiceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/create', name: 'create_service', methods: ['POST'])]
    public function createService(
        #[MapRequestPayload]
        CreateServiceDTO $serviceDTO,
        CreateServiceServiceInterface $createServiceService,
    ): JsonResponse {
        try {
            $service = $createServiceService->createServiceForm($serviceDTO);

            return $this->json([
                'message' => 'Service créé',
                'serviceId' => $service->getId(),
            ], 201);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 400);
        }
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/show', name: 'show_service', methods: ['GET'])]
    public function showServices(ListServiceService $listService): JsonResponse
    {
        $services = $listService->getAllServices();

        return $this->json($services);
    }

    
}
