<?php

namespace App\Controller\BrandingVerbal;

use App\Controller\AbstractApiController;
use App\Exception\GeminiApiException;
use App\Request\BrandingVerbal\CompanyToneOfVoiceRequest;
use App\Services\CompanyToneOfVoice\CompanyToneOfVoiceGeneratorServiceInterface;
use App\Services\TokenManager\TokenManagerServiceInterface;
use App\Utils\Validator\AppValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CompanyToneOfVoiceController extends AbstractApiController
{
    public function __construct(
        private AppValidator $validator,
        private CompanyToneOfVoiceGeneratorServiceInterface $companyToneOfVoiceService,
        // @phpstan-ignore property.onlyWritten
        private readonly TokenManagerServiceInterface $tokenManagerService,
    ) {
        parent::__construct($tokenManagerService);
    }

    #[IsGranted('ROLE_CLIENT')]
    #[Route('/generate/companyToneOfVoice', name: 'generation_companyToneOfVoice', methods: ['POST'])]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        if (!$this->handleServiceRequest('ton_voice_tokens')) {
            return $this->json([
                'message' => 'Quota reached message',
                'code' => 'QUOTA_REACHED_EXCEPTION',
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        $Inforequest = new CompanyToneOfVoiceRequest($request);

        $errorMessages = $this->validator->validateRequest($Inforequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $generatedToneOfVoice = $this->companyToneOfVoiceService->generateToneOfVoice($Inforequest);

            return $this->json([
                'success' => true,
                'Tone of Voice' => $generatedToneOfVoice,
            ], Response::HTTP_OK);
        } catch (GeminiApiException $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}
