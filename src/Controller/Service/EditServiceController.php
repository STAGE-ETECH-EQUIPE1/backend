<?php

namespace App\Controller\Service;

use App\Mapper\Subscription\ServiceMapper;
use App\Request\Subscription\ServiceRequest;
use App\Services\EditService\EditServiceService;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EditServiceController extends AbstractController
{
    private AppValidatorInterface $validator;
    private EditServiceService $editServiceService;

    public function __construct(
        AppValidatorInterface $validator,
        EditServiceService $editServiceService,
    ) {
        $this->validator = $validator;
        $this->editServiceService = $editServiceService;
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/edit/{id}', name: 'edit_service', methods: ['PUT'])]
    public function __invoke(
        int $id,
        Request $request,
    ): JsonResponse {
        $requestDTO = new ServiceRequest($request);
        $error = $this->validator->validateRequest($requestDTO);
        if (count($error) > 0) {
            return $this->json([
                'error' => $error,
            ], Response::HTTP_BAD_REQUEST);
        }

        $dto = ServiceMapper::fromRequest($requestDTO);
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
                'token' => $updated->getToken(),
            ],
        ]);
    }
}
