<?php

namespace App\Controller\Branding;

use App\Request\Branding\FileToProvideRequest;
use App\Response\Auth\ClientResponse;
use App\Services\Branding\BrandingServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class FileToProvideController extends AbstractController
{
    public function __construct(
        private readonly AppValidatorInterface $validator,
        private readonly BrandingServiceInterface $brandingService,
    ) {
    }

    #[Route(
        path: '/brandings/file-provide',
        name: 'brandings_file_to_provide',
        methods: ['POST']
    )]
    #[IsGranted('ROLE_CLIENT')]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $fileToProvideRequest = new FileToProvideRequest($request);

        $errorMessages = $this->validator->validateRequest($fileToProvideRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        $client = $this->brandingService->submitFileToProvide($fileToProvideRequest);

        return $this->json([
            'message' => 'file to provide',
            'success' => true,
            'data' => new ClientResponse($client),
        ]);
    }
}
