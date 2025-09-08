<?php

namespace App\Controller\BrandingVerbal;

use App\Request\BrandingVerbal\BrandingVerbalRequest;
use App\Response\Auth\ClientResponse;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SubmitCompanyNameController extends AbstractController
{
    public function __construct(
        private AppValidatorInterface $validator,
        private BrandingVerbalServiceInterface $brandingVerbalService,
    ) {
    }

    #[IsGranted('ROLE_CLIENT')]
    #[Route(path: '/brandingVerbal/companyName', name: 'submit__companyName', methods: ['POST'])]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $brandingVerbal = new BrandingVerbalRequest($request);

        $errorMessages = $this->validator->validateRequest($brandingVerbal);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        $client = $this->brandingVerbalService->submitCompanyName($brandingVerbal);

        return $this->json([
            'success' => true,
            'message' => 'Company Name Submitted Successfully',
            'data' => new ClientResponse($client),
        ]);
    }
}
