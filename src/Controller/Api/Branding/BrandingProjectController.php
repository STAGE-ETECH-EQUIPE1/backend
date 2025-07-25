<?php

namespace App\Controller\Api\Branding;

use App\DTO\Branding\DesignBriefDTO;
use App\Message\Branding\GenerateLogoMessage;
use App\Services\Branding\BrandingServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class BrandingProjectController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly BrandingServiceInterface $brandingService,
    ) {
    }

    #[Route(path: '/branding-project', name: 'branding_project_submit', methods: ['POST'])]
    #[IsGranted('ROLE_CLIENT')]
    public function submitBrief(
        #[MapRequestPayload]
        DesignBriefDTO $designBriefDTO,
    ): JsonResponse {
        $brief = $this->brandingService->createNewBrandingProject($designBriefDTO);
        $this->messageBus->dispatch(
            new GenerateLogoMessage(
                (int) $brief->getId()
            )
        );

        return $this->json([
            'message' => 'Design brief submitted successfully.',
            'status' => 'success',
            'prompt' => $this->brandingService->buildPromptText($designBriefDTO),
            'data' => $designBriefDTO,
        ]);
    }
}
