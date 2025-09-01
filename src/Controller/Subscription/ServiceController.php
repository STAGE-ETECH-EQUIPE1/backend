<?php

namespace App\Controller\Subscription;

use App\Mapper\Subscription\ServiceMapper;
use App\Request\Subscription\ServiceRequest;
use App\Services\CreateService\CreateServiceServiceInterface;
use App\Services\EditService\EditServiceService;
use App\Services\ListService\ListServiceService;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ServiceController extends AbstractController
{
    private EditServiceService $editServiceService;
    private AppValidatorInterface $validator;

    public function __construct(
        EditServiceService $editServiceService,
        AppValidatorInterface $validator,
    ) {
        $this->editServiceService = $editServiceService;
        $this->validator = $validator;
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/service/create', name: 'create_service', methods: ['POST'])]
    public function createService(
        Request $request,
        CreateServiceServiceInterface $createServiceService,
    ): JsonResponse {
        try {
            $requestDTO = new ServiceRequest($request);
            $error = $this->validator->validateRequest($requestDTO);

            if (count($error) > 0) {
                return $this->json([
                    'error' => $error,
                ], Response::HTTP_BAD_REQUEST);
            }

            $serviceDTO = ServiceMapper::fromRequest($requestDTO);
            $service = $createServiceService->createServiceForm($serviceDTO);

            return $this->json([
                'message' => 'Service créé',
                'id' => $service->getId(),
                'token' => $service->getToken(),
            ], 201);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ], 400);
        }
    }
}
