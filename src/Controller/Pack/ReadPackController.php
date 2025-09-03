<?php

namespace App\Controller\Pack;

use App\Services\ListPack\ListPackServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ReadPackController extends AbstractController
{
    public function __construct(
        private ListPackServiceInterface $listPackService,
    ) {
    }

    #[Route('/pack/show', name: 'show_pack', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $packsDto = $this->listPackService->getAllPacks();

        return $this->json($packsDto);
    }
}
