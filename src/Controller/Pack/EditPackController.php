<?php

namespace App\Controller\Pack;

use App\Mapper\Subscription\PackMapper;
use App\Request\Subscription\PackRequest;
use App\Services\EditPack\EditPackService;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EditPackController extends AbstractController
{
    private EditPackService $editPackService;
    private AppValidatorInterface $validator;

    public function __construct(
        EditPackService $editPackService,
        AppValidatorInterface $validator,
    ) {
        $this->editPackService = $editPackService;
        $this->validator = $validator;
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/pack/edit/{id}', name: 'edit_pack', methods: ['PUT'])]
    public function __invoke(
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
