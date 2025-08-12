<?php

namespace App\Controller\Branding;

use App\DTO\PaginationDTO;
use App\Services\LogoVersion\LogoVersionServiceInterface;
use App\Utils\Paginator\PaginatorUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
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
        #[MapQueryString]
        PaginationDTO $pagination,
        int $id,
    ): JsonResponse {
        [$results, $total] = $this->logoVersionService->getPaginatedLogoByBrandingId($id, $pagination);

        return $this->json([
            'message' => 'get All Logo from branding project',
            'data' => $this->logoVersionService->convertAllToDTO($results),
            ...PaginatorUtils::buildPageResponse($pagination, $total),
        ]);
    }
}
