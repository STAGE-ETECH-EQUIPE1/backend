<?php

namespace App\Controller\Api\Subscription;

use App\DTO\Subscription\CreatePackDTO;
use App\Services\CreatePack\CreatePackServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreatePackController extends AbstractController
{
    #[Route('/pack/create', name: 'create_pack', methods: ['POST'])]
    public function createPack(Request $request, ValidatorInterface $validator, SerializerInterface $serializer, CreatePackServiceInterface $createPackService): JsonResponse
    {
        $dto = $serializer->deserialize($request->getContent(), CreatePackDTO::class, 'json');
        $error = $validator->validate($dto);
        if (count($error) > 0) {
            return $this->json(['error' => 'invalid_dto'], 400);
        }

        try {
            $pack = $createPackService->createPackForm($dto);

            return $this->json([
                'message' => 'Pack créé',
                'packId' => $pack->getId(),
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }
}
