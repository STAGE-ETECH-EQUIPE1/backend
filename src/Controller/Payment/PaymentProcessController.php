<?php

namespace App\Controller\Payment;

use App\Request\Payment\CyberSourcePaymentRequest;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentProcessController extends AbstractController
{
    public function __construct(
        private readonly AppValidatorInterface $validator,
    ) {
    }

    #[Route(
        path: '/payment',
        name: 'payment_process',
        methods: ['POST']
    )]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $paymentRequest = new CyberSourcePaymentRequest($request);
        $errorMessages = $this->validator->validateRequest($paymentRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            'message' => 'payment process using cybersource',
        ]);
    }
}
