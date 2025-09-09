<?php

namespace App\Controller\Logo;

use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\LogoVersion;
use App\Event\PublishLogoEvent;
use App\Request\Logo\CommentLogoRequest;
use App\Response\Logo\LogoPublishResponse;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class TestPublishLogoController extends AbstractController
{
    public function __construct(
        private readonly AppValidatorInterface $validator,
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    #[Route(
        path: '/logo/{id}/publish',
        name: 'logo_publish',
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
                'message' => 'Validation error',
                'errors' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        /** @var BrandingProject $branding */
        $branding = $logoVersion->getBranding();

        $this->eventDispatcher->dispatch(new PublishLogoEvent($logoVersion, (int) $branding->getId()));

        return $this->json([
            'message' => 'Logo published successfully',
            'logo' => new LogoPublishResponse($logoVersion),
            'branding-id' => $branding->getId(),
        ]);
    }
}
