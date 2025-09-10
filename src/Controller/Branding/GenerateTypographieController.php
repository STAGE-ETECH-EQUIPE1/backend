<?php

namespace App\Controller\Branding;

use App\Controller\AbstractApiController;
use App\Request\Branding\TypographieGenerationRequest;
use App\Services\TokenManager\TokenManagerServiceInterface;
use App\Services\VisualIdentity\VisualIdentityServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GenerateTypographieController extends AbstractApiController
{
    public function __construct(
        private readonly VisualIdentityServiceInterface $visualIdentityService,
        private readonly AppValidatorInterface $validator,
        // @phpstan-ignore property.onlyWritten
        private readonly TokenManagerServiceInterface $tokenManagerService,
    ) {
        parent::__construct($tokenManagerService);
    }

    #[Route(
        path: '/brandings/typographies',
        name: 'brandings_typographies',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        if (!$this->handleServiceRequest('typography_tokens')) {
            return $this->json([
                'message' => 'Quota reached message',
                'code' => 'QUOTA_REACHED_EXCEPTION',
            ], Response::HTTP_TOO_MANY_REQUESTS);
        }

        $typographiesRequest = new TypographieGenerationRequest($request);

        $errorMessages = $this->validator->validateRequest($typographiesRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            'message' => 'typographie generated successfully !',
            'success' => true,
            'data' => $this->visualIdentityService->generateTypographies($typographiesRequest),
        ]);
    }
}
