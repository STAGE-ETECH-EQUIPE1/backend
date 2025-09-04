<?php

namespace App\Controller\User;

use App\Mapper\User\UserMapper;
use App\Request\User\UserRequest;
use App\Services\EditUser\EditUserServiceInterface;
use App\Utils\Validator\AppValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EditUserController extends AbstractController
{
    private EditUserServiceInterface $editUserService;
    private AppValidatorInterface $validator;

    public function __construct(
        EditUserServiceInterface $editUserService,
        AppValidatorInterface $validator,
    ) {
        $this->editUserService = $editUserService;
        $this->validator = $validator;
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/user/edit/{id}', name: 'edit_user', methods: ['PUT'])]
    public function __invoke(
        int $id,
        Request $request,
    ): JsonResponse {
        $request = new UserRequest($request);

        $errors = $this->validator->validateRequest($request);
        if (count($errors) > 0) {
            return $this->json(['errors' => $errors], Response::HTTP_BAD_REQUEST);
        }
        $dto = UserMapper::fromRequest($request);
        $updated = $this->editUserService->handle($id, $dto);

        if (!$updated) {
            return $this->json(['error' => 'User not found'], 404);
        }

        return $this->json([
            'message' => 'Update Success',
            'id' => $updated->getId(),
            'email' => $updated->getEmail(),
            'phone' => $updated->getPhone(),
            'fullName' => $updated->getFullName(),
        ]);
    }
}
