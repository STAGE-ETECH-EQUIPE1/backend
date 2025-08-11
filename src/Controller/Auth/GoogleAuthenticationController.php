<?php

namespace App\Controller\Auth;

use App\Request\Auth\GoogleAuthenticationRequest;
use App\Services\Auth\GoogleAuthenticationService;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GoogleAuthenticationController extends AbstractController
{
    public function __construct(
        private readonly GoogleAuthenticationService $googleAuthService,
        private readonly AppValidatorInterface $validator,
    ) {
    }

    #[Route(
        path: '/auth/google',
        name: 'auth_google',
        methods: ['POST']
    )]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $googleAuthRequest = new GoogleAuthenticationRequest($request);

        $errorMessages = $this->validator->validateRequest($googleAuthRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $token = $this->googleAuthService->authenticate($googleAuthRequest);

            return $this->json([
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return $this->json([
                'error' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
