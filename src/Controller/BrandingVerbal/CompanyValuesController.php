<?php

namespace App\Controller\BrandingVerbal;

use App\Exception\GeminiApiException;
use App\Request\BrandingVerbal\CompanyValuesRequest;
use App\Services\CompanyValues\CompanyValuesGeneratorServiceInterface;
use App\Utils\Validator\AppValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CompanyValuesController extends AbstractController
{
    public function __construct(
        private AppValidator $validator,
        private CompanyValuesGeneratorServiceInterface $companyValuesService,
    ) {
    }

    #[IsGranted('ROLE_CLIENT')]
    #[Route('/brandings/companyValues', name: 'generation_companyValues', methods: ['POST'])]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $Inforequest = new CompanyValuesRequest($request);

        $errorMessages = $this->validator->validateRequest($Inforequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $generatedCompanyValues = $this->companyValuesService->generateCompanyValues($Inforequest);

            return $this->json([
                'success' => true,
                'Values' => $generatedCompanyValues,
            ], Response::HTTP_OK);
        } catch (GeminiApiException $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
