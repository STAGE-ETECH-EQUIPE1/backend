<?php

namespace App\Controller\Payment;

use App\Response\Payment\SecureAcceptanceResponseDTO;
use App\Services\Payment\MainPayment\MainPaymentServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HandleResponseSecureAcceptanceCheckoutController extends AbstractController
{
    public function __construct(
        #[Autowire('%app.frontend_url%')]
        private readonly string $frontendUrl,
        private readonly MainPaymentServiceInterface $mainPaymentService,
    ) {
    }

    #[Route(
        path: '/payment/response',
        name: 'payment_response',
        methods: ['POST'],
    )]
    public function __invoke(
        Request $request,
    ): JsonResponse|Response {
        $secureAcceptanceResponseDTO = (new SecureAcceptanceResponseDTO())
            ->fromArray($request->request->all());

        try {
            $this->mainPaymentService->savePaymentFromResponseDTO($secureAcceptanceResponseDTO);
            $responseData = [
                'status' => Response::HTTP_OK,
                'transactionId' => $secureAcceptanceResponseDTO->getTransactionId(),
                'devisId' => $secureAcceptanceResponseDTO->getReqReferenceNumber(),
                'code' => $secureAcceptanceResponseDTO->getDecision(),
                'message' => $secureAcceptanceResponseDTO->getMessage(),
            ];
        } catch (\Throwable $th) {
            $responseData = [
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'transactionId' => $secureAcceptanceResponseDTO->getTransactionId(),
                'devisId' => $secureAcceptanceResponseDTO->getReqReferenceNumber(),
                'code' => 'SERVER_ERROR',
                'message' => $th->getMessage(),
            ];
        }

        $html =
        <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <title>Secure Acceptance Callback</title>
        </head>
        <body>
            <script>
                window.parent.postMessage(
                    {
                        status: '{$responseData['status']}',
                        transactionId: '{$responseData['transactionId']}',
                        referenceDevis: '{$responseData['devisId']}',
                        code: '{$responseData['code']}',
                        message: '{$responseData['message']}',
                    },
                    '{$this->frontendUrl}'
                );
            </script>
        </body>
        </html>
        HTML;

        return new Response($html);
    }
}
