<?php

namespace App\Controller\Auth;

use App\DTO\Request\ResetPasswordDTO;
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

    #[Route(
        path: '/reset-password',
        name: 'send_reset_password',
        methods: ['POST']
    )]
    public function __invoke(
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
}
