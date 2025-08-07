<?php

namespace App\Controller\Auth;

use App\DTO\Request\UpdatePasswordDTO;
use App\Services\Auth\AuthServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ResetPasswordController extends AbstractController
{
    public function __construct(
        private readonly AuthServiceInterface $authService,
    ) {
    }

    #[Route(
        path: '/reset-password/reset/{token}',
        name: 'reset_password',
        methods: ['POST']
    )]
    public function __invoke(
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
