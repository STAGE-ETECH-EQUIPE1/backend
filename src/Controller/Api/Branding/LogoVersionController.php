<?php

namespace App\Controller\Api\Branding;

use App\DTO\Request\CommentLogoDTO;
use App\Entity\Branding\LogoVersion;
use App\Services\LogoVersion\LogoVersionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class LogoVersionController extends AbstractController
{
    public function __construct(
        private readonly LogoVersionServiceInterface $logoVersionService,
    ) {
    }

    #[Route('/logo/{id}/feedbacks', name: 'logo_feedback_list', methods: ['GET'])]
    public function getLogoFeedBacks(
        int $id,
    ): JsonResponse {
        return $this->json([
            'message' => 'logo feedbacks',
            'data' => $this->logoVersionService->convertAllClientFeedBacksToDTO(
                $this->logoVersionService->getLogoFeedBackByLogoId($id)
            ),
        ]);
    }

    #[Route('/logo/{id}/comment', name: 'logo_comment', methods: ['POST'])]
    #[IsGranted('ROLE_CLIENT')]
    public function comentLogoById(
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
