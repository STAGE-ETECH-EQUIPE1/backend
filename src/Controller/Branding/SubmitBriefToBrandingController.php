<?php

namespace App\Controller\Branding;

use App\DTO\Branding\DesignBriefDTO;
use App\Entity\Branding\BrandingProject;
use App\Message\Branding\RegenerateLogoMessage;
use App\Services\Branding\BrandingServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SubmitBriefToBrandingController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly BrandingServiceInterface $brandingService,
    ) {
    }

    #[Route(
        path: '/branding-project/{id}/brief',
        name: 'branding_logo_brief',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(
        BrandingProject $brandingProject,
        #[MapRequestPayload]
        DesignBriefDTO $designBriefDTO,
    ): JsonResponse {
        $brief = $this->brandingService->submitDesignBriefByBrandingProjectId($brandingProject, $designBriefDTO);
        try {
            $this->messageBus->dispatch(
                new RegenerateLogoMessage(
                    (int) $brandingProject->getId(),
                    (int) $brief->getId()
                )
            );
        } catch (ExceptionInterface $e) {
            return $this->json([
                'message' => 'There is an error when submitting logo debrief',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'data' => $e->getMessage(),
            ]);
        }

        return $this->json([
            'message' => 'logo submitted successfully',
            'status' => Response::HTTP_OK,
            'data' => $designBriefDTO,
        ], Response::HTTP_OK);
    }
}
