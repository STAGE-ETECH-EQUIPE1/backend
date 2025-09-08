<?php

namespace App\Controller\Branding;

use App\Request\Branding\ColorPaletteGenerationRequest;
use App\Services\VisualIdentity\VisualIdentityServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GenerateColorPaletteController extends AbstractController
{
    public function __construct(
        private readonly VisualIdentityServiceInterface $visualIdentityService,
        private readonly AppValidatorInterface $validator,
    ) {
    }

    #[Route(
        path: '/brandings/color-palettes',
        name: 'brandings_color_palettes',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $colorPaletteRequest = new ColorPaletteGenerationRequest($request);

        $errorMessages = $this->validator->validateRequest($colorPaletteRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            ...$this->visualIdentityService->generateColorPalettes($colorPaletteRequest),
        ]);
    }
}
