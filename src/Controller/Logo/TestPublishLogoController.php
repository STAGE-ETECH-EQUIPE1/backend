<?php

namespace App\Controller\Logo;

use App\Entity\Branding\LogoVersion;
use App\Request\Logo\CommentLogoRequest;
use App\Services\LogoGeneration\LogoGenerationServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TestPublishLogoController extends AbstractController
{
    public function __construct(
        private readonly LogoGenerationServiceInterface $logoGenerationService,
        private readonly AppValidatorInterface $validator,
    ) {
    }

    #[Route(
        path: '/logo/{id}/publish',
        name: 'logo_publish',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(
        LogoVersion $logoVersion,
        Request $request,
    ): JsonResponse {
        $commentLogoRequest = new CommentLogoRequest($request);

        $errorMessages = $this->validator->validateRequest($commentLogoRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'message' => 'Validation error',
                'errors' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->logoGenerationService->publishLogo($logoVersion);

        return $this->json([
            'message' => 'Logo published successfully',
        ]);
    }
}
