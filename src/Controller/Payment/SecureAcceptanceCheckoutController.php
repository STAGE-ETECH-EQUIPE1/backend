<?php

namespace App\Controller\Payment;

use App\DTO\Payment\CyberSourcePaymentDataDTO;
use App\Services\Payment\CyberSource\CybersourceSecureAcceptanceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SecureAcceptanceCheckoutController extends AbstractController
{
    public function __construct(
        private readonly CybersourceSecureAcceptanceInterface $cybersourceSecureAcceptance,
    ) {
    }

    #[Route(
        path: '/secure-acceptance/init/{id}',
        name: 'secure_acceptance_checkout',
        methods: ['GET']
    )]
    public function __invoke(
        string $id,
    ): JsonResponse {
        try {
            [$data, $cybersourceUrl] = $this->cybersourceSecureAcceptance->preparePaymentData(
                new CyberSourcePaymentDataDTO(
                    amount: '10000.00',
                    transactionUuid: uniqid('txn_', true),
                    transactionType: 'authorization',
                    referenceNumber: uniqid("ORDER-$id-", true),
                    billToForename: 'John',
                    billToSurname: 'Doe',
                    billToCompanyName: 'Company Name',
                    billToEmail: 'john.doe@domain.fr',
                    billToAddressLine1: '1 Market St',
                    billToAddressState: 'CA',
                    billToAddressCountry: 'US',
                    billToAddressCity: 'San Francisco',
                    billToZip: '123456',
                    billToPhone: '1234567890',
                    billToAddressPostalCode: '94105',
                ));

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
