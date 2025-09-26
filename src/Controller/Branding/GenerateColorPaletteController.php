<?php

namespace App\Controller\Branding;

use App\Controller\AbstractApiController;
use App\Request\Branding\ColorPaletteGenerationRequest;
use App\Services\TokenManager\TokenManagerServiceInterface;
use App\Services\VisualIdentity\VisualIdentityServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GenerateColorPaletteController extends AbstractApiController
{
    public function __construct(
        private readonly VisualIdentityServiceInterface $visualIdentityService,
        private readonly AppValidatorInterface $validator,
        // @phpstan-ignore property.onlyWritten
        private readonly TokenManagerServiceInterface $tokenManagerService,
    ) {
        parent::__construct($tokenManagerService);
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
        if (!$this->handleServiceRequest('color_palette_tokens')) {
            return $this->json([
                'message' => 'Quota reached message',
                'code' => 'QUOTA_REACHED_EXCEPTION',
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        $colorPaletteRequest = new ColorPaletteGenerationRequest($request);

        $errorMessages = $this->validator->validateRequest($colorPaletteRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            'message' => 'Color Palette generated successfully !',
            'success' => true,
            'data' => $this->visualIdentityService->generateColorPalettes($colorPaletteRequest),
        ]);
    }
}
