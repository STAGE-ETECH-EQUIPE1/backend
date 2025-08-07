<?php

namespace App\Controller\Logo;

use App\Services\LogoVersion\LogoVersionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    ): JsonResponse {
        return $this->json([
            'message' => 'logo feedbacks',
            'data' => $this->logoVersionService->convertAllClientFeedBacksToDTO(
                $this->logoVersionService->getLogoFeedBackByLogoId($id)
            ),
        ]);
    }
}
