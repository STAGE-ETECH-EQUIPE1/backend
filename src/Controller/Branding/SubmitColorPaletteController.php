<?php

namespace App\Controller\Branding;

use App\Response\Auth\ClientResponse;
use App\Services\VisualIdentity\VisualIdentityServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SubmitColorPaletteController extends AbstractController
{
    public function __construct(
        private readonly VisualIdentityServiceInterface $visualIdentityService,
    ) {
    }

    #[Route(
        path: '/brandings/color-palettes/submit',
        name: 'branding_submit_color_palettes',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $client = $this->visualIdentityService->submitColorPalette($request);

        return $this->json([
            'success' => true,
            'message' => 'Color Palettes Submitted Successfully',
            'data' => new ClientResponse($client),
        ]);
    }
}
