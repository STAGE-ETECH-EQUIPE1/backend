<?php

namespace App\Controller\Api\Auth;

use App\DTO\Request\GoogleAuthenticationDTO;
use App\Services\Auth\GoogleAuthenticationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GoogleAuthenticationController extends AbstractController
{
    public function __construct(
        private GoogleAuthenticationService $googleAuthService,
    ) {
    }

    #[Route('/auth/google', name: 'auth_google', methods: ['POST'])]
    public function googleLogin(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data) || !isset($data['id_token'])) {
            return $this->json(['error' => 'Missing or invalid id_token'], 400);
        }
        $dto = new GoogleAuthenticationDTO();
        $dto->idToken = $data['id_token'];

        $errors = $validator->validate($dto);
        if (count($errors) > 0) {
            return $this->json(['error' => (string) $errors], 400);
        }

        try {
            $token = $this->googleAuthService->authenticate($dto);
            return $this->json(['token' => $token]);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }
}
