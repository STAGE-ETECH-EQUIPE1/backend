<?php

namespace App\Controller\Api\Auth;

use App\DTO\Request\ResetPasswordDTO;
use App\DTO\Request\UpdatePasswordDTO;
use App\Services\Auth\AuthServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ResetPasswordController extends AbstractController
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
    ) {
    }

    #[Route('/reset-password', name: 'forgot_password_request', methods: ['POST'])]
    public function sendResetPasswordRequest(
        #[MapRequestPayload]
        ResetPasswordDTO $resetPasswordDTO,
    ): JsonResponse {
        try {
            $this->authService->sendResetPasswordEmail($resetPasswordDTO->getEmail());

            return $this->json([
                'message' => 'Reset password email sent for the provided email.',
            ], Response::HTTP_OK);
        } catch (\Exception $exception) {
            return $this->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/reset-password/reset/{token}', name: 'reset_password', methods: ['POST'])]
    public function resetPassword(
        #[MapRequestPayload]
        UpdatePasswordDTO $updatePasswordDTO,
        string $token,
    ): JsonResponse {
        $this->authService->updateUserPassword($token, $updatePasswordDTO);

        return $this->json([
            'message' => 'Password reset successfully.',
        ]);
    }
}
