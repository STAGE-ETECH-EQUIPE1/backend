<?php

namespace App\Controller\Branding;

use App\Request\Branding\VisualIdentityRequest;
use App\Response\Auth\ClientResponse;
use App\Services\VisualIdentity\VisualIdentityServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SubmitTypographieController extends AbstractController
{
    public function __construct(
        private readonly AppValidatorInterface $validator,
        private readonly VisualIdentityServiceInterface $visualIdentityService,
    ) {
    }

    #[Route(
        path: '/brandings/typographies',
        name: 'branding_submit_typographies',
        methods: ['GET']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $visualIdentityRequest = new VisualIdentityRequest($request);

        $errorMessages = $this->validator->validateRequest($visualIdentityRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        $client = $this->visualIdentityService->submitTypographie($visualIdentityRequest);

        return $this->json([
            'success' => true,
            'message' => 'Color Palettes Submitted Successfully',
            'data' => new ClientResponse($client),
        ]);
    }
}
