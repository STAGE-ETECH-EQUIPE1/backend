<?php

namespace App\Controller\BrandingVerbal;

use App\Controller\AbstractApiController;
use App\Exception\GeminiApiException;
use App\Request\BrandingVerbal\CompanySloganRequest;
use App\Services\CompanySlogan\CompanySloganGeneratorServiceInterface;
use App\Services\TokenManager\TokenManagerServiceInterface;
use App\Utils\Validator\AppValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CompanySloganController extends AbstractApiController
{
    public function __construct(
        private AppValidator $validator,
        private CompanySloganGeneratorServiceInterface $companySloganService,
        // @phpstan-ignore property.onlyWritten
        private readonly TokenManagerServiceInterface $tokenManagerService,
    ) {
        parent::__construct($tokenManagerService);
    }

    #[IsGranted('ROLE_CLIENT')]
    #[Route('/brandings/companySlogan', name: 'generation_companySlogan', methods: ['POST'])]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        if (!$this->handleServiceRequest('slogan_tokens')) {
            return $this->json([
                'message' => 'Quota reached message',
                'code' => 'QUOTA_REACHED_EXCEPTION',
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        $Inforequest = new CompanySloganRequest($request);

        $errorMessages = $this->validator->validateRequest($Inforequest);
        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $generatedSlogan = $this->companySloganService->generateCompanySlogans($Inforequest);

            return $this->json([
                'success' => true,
                'Slogans' => $generatedSlogan,
            ], Response::HTTP_OK);
        } catch (GeminiApiException $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
