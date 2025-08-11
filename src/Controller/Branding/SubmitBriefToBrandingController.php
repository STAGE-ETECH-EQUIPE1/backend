<?php

namespace App\Controller\Branding;

use App\Entity\Branding\BrandingProject;
use App\Message\Branding\RegenerateLogoMessage;
use App\Request\Branding\DesignBriefRequest;
use App\Services\Branding\BrandingServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SubmitBriefToBrandingController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly BrandingServiceInterface $brandingService,
        private readonly AppValidatorInterface $validator,
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
        Request $request,
    ): JsonResponse {
        $designBriefRequest = new DesignBriefRequest($request);

        $errorMessages = $this->validator->validateRequest($designBriefRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        $brief = $this->brandingService->submitDesignBriefByBrandingProjectId($brandingProject, $designBriefRequest);

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
            'data' => $designBriefRequest,
        ], Response::HTTP_OK);
    }
}
