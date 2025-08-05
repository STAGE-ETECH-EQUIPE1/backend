<?php

namespace App\Controller\Api\Branding;

use App\DTO\Branding\DesignBriefDTO;
use App\Entity\Branding\BrandingProject;
use App\Message\Branding\GenerateLogoMessage;
use App\Message\Branding\RegenerateLogoMessage;
use App\Services\Branding\BrandingServiceInterface;
use App\Services\LogoVersion\LogoVersionServiceInterface;
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
        private readonly LogoVersionServiceInterface $logoVersionService,
    ) {
    }

    #[Route('/branding-project', name: 'branding_project_list', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT')]
    public function getBrandingProjectForUser(): JsonResponse
    {
        return $this->json([
            'message' => 'get All Branding Project for connected user',
            'data' => $this->brandingService->convertAllToDTO(
                $this->brandingService->getAllBrandingProject()
            ),
        ]);
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
    public function submitLogoBriefToBrandingProject(
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

    #[Route('/branding-project/{id}/logo', name: 'branding_logo_view', methods: ['GET'])]
    #[IsGranted('ROLE_CLIENT')]
    public function getAllLogoFromBrandingProject(
        BrandingProject $brandingProject,
    ): JsonResponse {
        return $this->json([
            'message' => 'get All Logo from branding project',
            'data' => $this->logoVersionService->convertAllToDTO(
                $this->logoVersionService->getLogoByBrandingId($brandingProject)
            ),
        ]);
    }
}
