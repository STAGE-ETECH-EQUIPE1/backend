<?php


namespace App\Controller\Payment;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class HandleResponseSecureAcceptanceCheckoutController extends AbstractController
{
    public function __construct(){}

    #[Route(
        path: '/payment/response',
        name: 'payment_response',
    )]
    public function __invoke(
        Request $request
    ): JsonResponse
    {
        return $this->json(['status' => 'success']);
    }
}
