<?php

namespace App\Controller\Api\Subscription;

use App\DTO\Subscription\CreatePackDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CreatePackController extends AbstractController
{
    #[Route('/pack/create', name: 'create_pack', methods: ['POST'])]
    public function createPack(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $dto = new CreatePackDTO();
        $dto->name = $data['name'];
        // tous les info de data
        
        $error = $validator->validate($dto);
        if (count($error) > 0)
        {
            return $this->json([
                'error' => 'invalid_dto'
            ]);
        }

        return $this->json([
            'message' => 'EndPoint Creation pack'
        ]);
    }
}