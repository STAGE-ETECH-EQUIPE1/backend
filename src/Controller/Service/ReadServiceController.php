<?php

namespace App\Controller\Service;

use App\Services\ListService\ListServiceService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReadServiceController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/show', name: 'show_service', methods: ['GET'])]
    public function showServices(ListServiceService $listService): JsonResponse
    {
        $services = $listService->getAllServices();

        return $this->json([
            'message' => 'listShow',
        ]);
    }
}