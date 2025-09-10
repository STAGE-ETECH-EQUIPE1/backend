<?php

namespace App\Controller\Branding;

use App\Request\Branding\TypographieGenerationRequest;
use App\Services\VisualIdentity\VisualIdentityServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class GenerateTypographieController extends AbstractController
{
    public function __construct(
        private readonly VisualIdentityServiceInterface $visualIdentityService,
        private readonly AppValidatorInterface $validator,
    ) {
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
