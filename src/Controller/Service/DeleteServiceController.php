<?php

namespace App\Controller\Service;

use App\Services\DeleteService\DeleteServiceServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DeleteServiceController extends AbstractController
{
    public function __construct(
        private DeleteServiceServiceInterface $serviceService,
    ) {
    }

    #[Route('/service/delete/{id}', name: 'delete_service', methods: ['DELETE'])]
    public function __invoke(
        int $id,
    ): JsonResponse {
        try {
            return $this->serviceService->deleteServiceById($id);
        } catch (\Exception $e) {
            return $this->json([
                'error' => 'Delete Error',
            ]);
        }
    }
}
