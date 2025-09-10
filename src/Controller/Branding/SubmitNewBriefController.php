<?php

namespace App\Controller\Branding;

use App\Controller\AbstractApiController;
use App\Entity\Branding\BrandingProject;
use App\Message\Branding\GenerateLogoMessage;
use App\Request\Branding\DesignBriefRequest;
use App\Services\Branding\BrandingServiceInterface;
use App\Services\TokenManager\TokenManagerServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SubmitNewBriefController extends AbstractApiController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly BrandingServiceInterface $brandingService,
        private readonly AppValidatorInterface $validator,
        private readonly TokenManagerServiceInterface $tokenManagerService,
    ) {
        parent::__construct($tokenManagerService);
    }

    #[Route(
        path: '/branding-project',
        name: 'branding_project_submit',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        if (!$this->handleServiceRequest('logo_generation_tokens')) {
            return $this->json([
                'message' => 'Quota reached message',
                'code' => 'QUOTA_REACHED_EXCEPTION',
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        $designBriefRequest = new DesignBriefRequest($request);

        $errorMessages = $this->validator->validateRequest($designBriefRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        $brief = $this->brandingService->createNewBrandingProject($designBriefRequest);

        /** @var BrandingProject $project */
        $project = $brief->getBranding();

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
            'data' => $designBriefRequest,
            'projectId' => $project->getId(),
        ], Response::HTTP_OK);
    }
}
