<?php

namespace App\Controller\Api\Subscription;

use App\DTO\Subscription\CreateServiceDTO;
use App\Services\CreateService\CreateServiceServiceInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;

class CreateServiceController extends AbstractController
{
    #[Route('packe/service/create', name: "create_service", methods:['POST'])]
    public function createService(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, CreateServiceServiceInterface $createServiceService): JsonResponse
    {
        $dto = $serializer->deserialize($request->getContent(), CreateServiceDTO::class, 'json');
        $error = $validator->validate($dto);
        if (count($error) > 0) {
            return $this->json(['error' => 'invalid_dto'], 400);
        }

        try {
            $service = $createServiceService->createServiceForm($dto);

            return $this->json([
                'message' => 'Service créé',
                'serviceId' => $service->getId(),
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }
}