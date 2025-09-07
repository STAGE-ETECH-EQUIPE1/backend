<?php

namespace App\Controller\Auth;

use App\Security\EmailVerifier;
use App\Services\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VerifyEmailController extends AbstractController
{
    public function __construct(
        private readonly EmailVerifier $emailVerifier,
        private readonly UserServiceInterface $userService,
    ) {
    }

    #[Route(
        path: '/email-verify',
        name: 'verify_email',
        methods: ['GET']
    )]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        try {
            $user = $this->userService->getById((int) $request->get('id'));
            $this->emailVerifier->handleEmailConfirmation($request, $user);

            return $this->json([
                'message' => 'USER_VERIFIED_SUCCESSFULLY',
                'success' => true,
            ]);
        } catch (\Throwable $th) {
            return $this->json([
                'message' => $th->getMessage(),
                'success' => false,
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
