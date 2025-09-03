<?php

namespace App\Controller\Logo;

use App\DTO\PaginationDTO;
use App\Services\LogoVersion\LogoVersionServiceInterface;
use App\Utils\Paginator\PaginatorUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;

class GetLogoFeedBacksController extends AbstractController
{
    public function __construct(
        private readonly LogoVersionServiceInterface $logoVersionService,
    ) {
    }

    #[Route(
        path: '/logo/{id}/feedbacks',
        name: 'logo_feedback_list',
        methods: ['GET']
    )]
    public function __invoke(
        int $id,
        #[MapQueryString]
        PaginationDTO $pagination,
    ): JsonResponse {
        [$results, $total] = $this->logoVersionService->paginateLogoFeedBackByLogoId($id, $pagination);

        return $this->json([
            'message' => 'logo feedbacks',
            'data' => $this->logoVersionService->convertAllClientFeedBacksToDTO(
                $results
            ),
            ...PaginatorUtils::buildPageResponse($pagination, $total),
        ]);
    }
}
