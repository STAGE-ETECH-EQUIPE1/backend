<?php

namespace App\Controller\Logo;

use App\DTO\Request\CommentLogoDTO;
use App\Entity\Branding\LogoVersion;
use App\Services\LogoVersion\LogoVersionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CommentLogoController extends AbstractController
{
    public function __construct(
        private readonly LogoVersionServiceInterface $logoVersionService,
    ) {
    }

    #[Route(
        path: '/logo/{id}/comment',
        name: 'logo_comment',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(
        LogoVersion $logoVersion,
        #[MapRequestPayload]
        CommentLogoDTO $commentLogoDTO,
    ): JsonResponse {
        $this->logoVersionService->commentLogo($logoVersion, $commentLogoDTO);

        return $this->json(
            [
                'message' => 'logo commented successfully',
                'id' => $logoVersion->getId(),
                'data' => $commentLogoDTO,
            ],
            Response::HTTP_OK
        );
    }
}
