<?php

namespace App\Controller\Auth;

use App\Request\Auth\UpdatePasswordRequest;
use App\Services\Auth\AuthServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResetPasswordController extends AbstractController
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
        private readonly AppValidatorInterface $validator,
    ) {
    }

    #[Route(
        path: '/auth/reset-password/reset/{token}',
        name: 'reset_password',
        methods: ['POST']
    )]
    public function __invoke(
        Request $request,
        string $token,
    ): JsonResponse {
        $updatePasswordRequest = new UpdatePasswordRequest($request);
        $errorMessages = $this->validator->validateRequest($updatePasswordRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->authService->updateUserPassword($token, $updatePasswordRequest);

        return $this->json([
            'message' => 'Password reset successfully.',
        ]);
    }
}
