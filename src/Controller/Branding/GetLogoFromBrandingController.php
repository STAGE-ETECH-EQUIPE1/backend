<?php

namespace App\Controller\Branding;

use App\Entity\Branding\BrandingProject;
use App\Services\LogoVersion\LogoVersionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class GetLogoFromBrandingController extends AbstractController
{
    public function __construct(
        private readonly LogoVersionServiceInterface $logoVersionService,
    ) {
    }

    #[Route(
        path: '/branding-project/{id}/logos',
        name: 'branding_project_logos',
        methods: ['GET'],
    )]
    public function __invoke(
        BrandingProject $brandingProject,
    ): JsonResponse {
        return $this->json([
            'message' => 'get All Logo from branding project',
            'data' => $this->logoVersionService->convertAllToDTO(
                $this->logoVersionService->getLogoByBrandingId($brandingProject)
            ),
        ]);
    }
}
