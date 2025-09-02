<?php

namespace App\Controller\Service;

use App\Services\ListService\ListServiceServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ReadServiceController extends AbstractController
{
    public function __construct(
        private ListServiceServiceInterface $listService,
    ) {}

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/show', name: 'show_services', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $packsDto = $this->listService->getAllServices();

        return $this->json($packsDto);
    }
}
