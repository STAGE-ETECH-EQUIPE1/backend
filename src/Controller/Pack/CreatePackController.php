<?php

namespace App\Controller\Pack;

use App\Mapper\Subscription\PackMapper;
use App\Request\Subscription\PackRequest;
use App\Services\CreatePack\CreatePackServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CreatePackController extends AbstractController
{
    private AppValidatorInterface $validator;
    private CreatePackServiceInterface $createPackService;

    public function __construct(
        CreatePackServiceInterface $createPackService,
        AppValidatorInterface $validator,
    ) {
        $this->createPackService = $createPackService;
        $this->validator = $validator;
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/pack/create', name: 'create_pack', methods: ['POST'])]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        try {
            $request = new PackRequest($request);
            $error = $this->validator->validateRequest($request);
            if (count($error) > 0) {
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
}
