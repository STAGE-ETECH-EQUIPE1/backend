<?php

namespace App\Controller\Payment;

use App\Services\Payment\CyberSource\CybersourceSecureAcceptanceInterface;
use App\Services\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SecureAcceptanceCheckoutController extends AbstractController
{
    public function __construct(
        private readonly CybersourceSecureAcceptanceInterface $cybersourceSecureAcceptance,
        private readonly UserServiceInterface $userService,
    ) {
    }

    #[Route(
        path: '/secure-acceptance/init/{id}',
        name: 'secure_acceptance_checkout',
        methods: ['GET']
    )]
    #[IsGranted('ROLE_USER')]
    public function __invoke(
        int $id,
    ): JsonResponse {
        try {
            [$data, $cybersourceUrl] = $this->cybersourceSecureAcceptance->preparePaymentData(
                $this->cybersourceSecureAcceptance->buildDataForPaymentProcessWithPackId($id)
            );

            return $this->json([
                'success' => true,
                'data' => [
                    'formData' => $data,
                    'cybersourceUrl' => $cybersourceUrl,
                ],
            ]);
        } catch (\Throwable $exception) {
            return $this->json([
                'success' => false,
                'error' => 'internal_error',
                'message' => 'Une erreur inattendue s\'est produite',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
