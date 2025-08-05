<?php

namespace App\Controller\Api\Branding;

use App\DTO\Request\CommentLogoDTO;
use App\Entity\Branding\LogoVersion;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class LogoVersionController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('/logo/{id}/comment', name: 'logo_comment', methods: ['POST'])]
    public function comentLogoById(
        LogoVersion $logoVersion,
        #[MapRequestPayload]
        CommentLogoDTO $commentLogoDTO,
    ): JsonResponse {
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
