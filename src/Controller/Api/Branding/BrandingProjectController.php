<?php

namespace App\Controller\Api\Branding;

use App\DTO\Branding\DesignBriefDTO;
use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\DesignBrief;
use App\Message\Branding\GenerateLogoMessage;
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
        try {
            $this->messageBus->dispatch(
                new GenerateLogoMessage(
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
            'message' => 'Design brief submitted successfully.',
            'status' => Response::HTTP_OK,
            'data' => $designBriefDTO,
        ], Response::HTTP_OK);
    }

    #[Route(path: '/branding-project/{id}/brief', name: 'branding_logo_brief', methods: ['POST'])]
    #[IsGranted('ROLE_CLIENT')]
    public function submitLogo(
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

    #[Route(path: '/branding/test', name: 'test_branding', methods: ['POST'])]
    public function testDesignValidation(
        #[MapRequestPayload]
        DesignBriefDTO $designBriefDTO,
    ): JsonResponse {
        $brief = (new DesignBrief())
            ->setColorPreferences($designBriefDTO->getColorPreferences())
            ->setLogoStyle('modern')
            ->setSlogan($designBriefDTO->getSlogan());

        return $this->json([
            'message' => 'Validation Design Brief DTO',
            'data' => $designBriefDTO,
            'brief' => $brief,
        ]);
    }
}
