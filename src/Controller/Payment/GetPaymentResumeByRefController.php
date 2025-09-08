<?php

namespace App\Controller\Payment;

use App\Exception\ResourceNotFoundException;
use App\Services\Payment\CyberSource\CybersourceSecureAcceptanceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GetPaymentResumeByRefController extends AbstractController
{
    public function __construct(
        private readonly CybersourceSecureAcceptanceInterface $cybersourceSecureAcceptance,
    ) {
    }

    #[Route(
        path: '/payment/resume',
        name: 'payment_resume',
        methods: ['GET']
    )]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        try {
            return $this->json([
                'success' => true,
                'data' => $this->cybersourceSecureAcceptance->getPaymentResumeResponsefromArrayQuery(
                    $request->query->all()
                ),
            ]);
        } catch (ResourceNotFoundException $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        } catch (\Throwable $th) {
            return $this->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
