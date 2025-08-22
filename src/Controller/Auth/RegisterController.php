<?php

namespace App\Controller\Auth;

use App\Request\Auth\UserRegistrationRequest;
use App\Services\User\UserServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly EntityManagerInterface $entityManager,
        private readonly JWTTokenManagerInterface $jwtManager,
        private readonly AppValidatorInterface $validator,
    ) {
    }

    #[Route(
        path: '/register',
        name: 'register_user',
        methods: ['POST']
    )]
    public function __invoke(
        Request $request,
    ): JsonResponse {
        $userRegistrationRequest = new UserRegistrationRequest($request);

        $errorMessages = $this->validator->validateRequest($userRegistrationRequest);

        if (count($errorMessages) > 0) {
            return $this->json([
                'error' => $errorMessages,
            ], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->userService->convertUserRegistrationDtoToUser($userRegistrationRequest);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        $token = $this->jwtManager->create($user);

        return $this->json([
            'message' => 'User Registration successful',
            'token' => $token,
            'user' => $this->userService->convertToDto($user),
            'statusCode' => Response::HTTP_CREATED,
        ], Response::HTTP_CREATED);
    }
}
