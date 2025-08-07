<?php

namespace App\Controller\Branding;

use App\Services\Branding\BrandingServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GetUserBrandingController extends AbstractController
{
    public function __construct(
        private readonly BrandingServiceInterface $brandingService,
    ) {
    }

    #[Route(
        path: '/branding-projects',
        name: 'branding_user_projects',
        methods: ['GET'],
        defaults: [
            '_api_operation_name' => '_api_/branding-projects',
        ],
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'message' => 'get All Branding Project for connected user',
            'data' => $this->brandingService->convertAllToDTO(
                $this->brandingService->getAllBrandingProject()
            ),
        ]);
    }
}
