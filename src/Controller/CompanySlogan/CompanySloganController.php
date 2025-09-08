<?php

namespace App\Controller\CompanySlogan;

use App\Exception\GeminiApiException;
use App\Request\CompanySlogan\CompanySloganRequest;
use App\Services\CompanySlogan\CompanySloganGeneratorServiceInterface;
use App\Utils\Validator\AppValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CompanySloganController extends AbstractController
{
    public function __construct(
        private AppValidator $validator,
        private CompanySloganGeneratorServiceInterface $companySloganService,
    )
    {}
    
    #[IsGranted('ROLE_CLIENT')]
    #[Route('/generate/companySlogan', name: 'generation_companySlogan', methods: ['POST'])]
    public function __invoke(
        Request $request
    ): JsonResponse
    {
        $Inforequest = new CompanySloganRequest($request);

        $errorMessages = $this->validator->validateRequest($Inforequest);
        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        try
        {
            $generatedSlogan = $this->companySloganService->generateCompanySlogans($Inforequest);
            return $this->json([
                'success' => true,
                'Slogans' => $generatedSlogan
            ], Response::HTTP_OK);
        }
        catch (GeminiApiException $e)
        {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }
}