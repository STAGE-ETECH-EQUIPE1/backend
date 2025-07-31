<?php

namespace App\Controller\Api\Subscription;

use App\DTO\Subscription\PackDTO;
use App\DTO\Subscription\ServiceDTO;
use App\Repository\Subscription\ServiceRepository;
use App\Services\CreateService\CreateServiceServiceInterface;
use App\Services\editService\editServiceService;
use App\Services\ListService\ListServiceService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ServiceController extends AbstractController
{
    // #[IsGranted('ROLE_ADMIN')]
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

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/edit/{id}', name: 'edit_service', methods: ['PUT'])]
    public function editServices(
        int $id,
        #[MapRequestPayload(validationGroups: ['update'])] ServiceDTO $dto,
        editServiceService $service,
    ) : JsonResponse {

        $updated  = $this->$service->handle($id, $dto);
        if (!$updated) {
            return $this->json(['error' => 'Service not found'], 404);
        }
        
        return $this->json([
            'message:' => 'Update Success',
            'Service id' => $id,
        ]);
    }
}
