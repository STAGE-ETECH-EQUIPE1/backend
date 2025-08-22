<?php

namespace App\Controller\Auth;

use App\Request\Auth\ResetPasswordRequest;
use App\Services\Auth\AuthServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SendResetPasswordController extends AbstractController
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
        private readonly AppValidatorInterface $validator,
    ) {
    }

    #[Route(
        path: '/reset-password',
        name: 'send_reset_password',
        methods: ['POST']
    )]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $resetPasswordRequest = new ResetPasswordRequest($request);

        $errorMessages = $this->validator->validateRequest($resetPasswordRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $this->authService->sendResetPasswordEmail($resetPasswordRequest->getEmail());

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
