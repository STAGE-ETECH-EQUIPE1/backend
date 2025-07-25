<?php

namespace App\Controller\Api\Branding;

use App\DTO\Branding\DesignBriefDTO;
use App\Message\Branding\GenerateLogoMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class BrandingProjectController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    #[Route(path: '/branding-project', name: 'branding_project_submit', methods: ['POST'])]
    public function submitBrief(
        #[MapRequestPayload]
        DesignBriefDTO $designBriefDTO,
    ): JsonResponse {
        $this->messageBus->dispatch(
            new GenerateLogoMessage(10)
        );

        return $this->json([
            'message' => 'Design brief submitted successfully.',
            'status' => 'success',
            'data' => $designBriefDTO,
        ]);
    }
}
