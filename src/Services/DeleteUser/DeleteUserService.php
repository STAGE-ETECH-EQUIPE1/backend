<?php

namespace App\Services\DeleteUser;

use App\Repository\Auth\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserService implements DeleteUserServiceInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $em,
    ) {
    }

    public function deleteUserById(int $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            throw new \Exception();
        }

        $date = new \DateTimeImmutable();
        $user->setDeleteAt($date);

        $this->em->flush();

        return new JsonResponse([
            'message' => 'Delete User success',
            'userId' => $user->getId(),
        ], 200);
    }
}
