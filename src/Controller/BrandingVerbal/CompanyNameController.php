<?php

namespace App\Controller\BrandingVerbal;

use App\Exception\GeminiApiException;
use App\Request\BrandingVerbal\CompanyNameRequest;
use App\Services\CompanyName\CompanyNameGeneratorServiceInterface;
use App\Utils\Validator\AppValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CompanyNameController extends AbstractController
{
    public function __construct(
        private AppValidator $validator,
        private CompanyNameGeneratorServiceInterface $companyNameService,
    ) {
    }

    #[IsGranted('ROLE_CLIENT')]
    #[Route('/generate/companyName', name: 'generation_companyName', methods: ['POST'])]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $Inforequest = new CompanyNameRequest($request);

        $errorMessages = $this->validator->validateRequest($Inforequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $generatedNames = $this->companyNameService->generateCompanyNames($Inforequest);

            return $this->json([
                'success' => true,
                'Names' => $generatedNames,
            ], Response::HTTP_OK);
        } catch (GeminiApiException $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
