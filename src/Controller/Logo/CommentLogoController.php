<?php

namespace App\Controller\Logo;

use App\Entity\Branding\LogoVersion;
use App\Request\Logo\CommentLogoRequest;
use App\Services\LogoVersion\LogoVersionServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CommentLogoController extends AbstractController
{
    public function __construct(
        private readonly LogoVersionServiceInterface $logoVersionService,
        private readonly AppValidatorInterface $validator,
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
        Request $request,
    ): JsonResponse {
        $commentLogoRequest = new CommentLogoRequest($request);
        $errorMessages = $this->validator->validateRequest($commentLogoRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->logoVersionService->commentLogo($logoVersion, $commentLogoRequest);

        return $this->json(
            [
                'message' => 'logo commented successfully',
                'id' => $logoVersion->getId(),
                'data' => $commentLogoRequest,
            ],
            Response::HTTP_OK
        );
    }
}
