<?php

namespace App\Controller\Subscription;

use App\Exception\ResourceNotFoundException;
use App\Services\Pack\PackServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetPackByIdController extends AbstractController
{
    public function __construct(
        private readonly PackServiceInterface $packService,
    ) {
    }

    #[Route(
        path: '/packs/{id}',
        name: 'packs_get_id',
        methods: ['GET']
    )]
    public function __invoke(
        int $id,
    ): JsonResponse {
        try {
            $pack = $this->packService->getById($id);

            return $this->json([
                'success' => true,
                'message' => 'All Pack Informations',
                'data' => $this->packService->convertToResponse($pack),
            ], Response::HTTP_OK);
        } catch (ResourceNotFoundException $ex) {
            return $this->json([
                'succes' => false,
                'code' => 'PACK_NOT_FOUND_ERROR',
                'message' => $ex->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->json([
                'succes' => false,
                'code' => 'INTERNAL_SERVER_ERROR',
                'message' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
