<?php

namespace App\Services\EditUser;

use App\DTO\User\UserDTO;
use App\Entity\Auth\User;
use App\Services\User\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class EditUserService implements EditUserServiceInterface
{
    public function __construct(
        private UserServiceInterface $userService,
        private EntityManagerInterface $em,
    ) {
    }

    public function handle(int $id, UserDTO $dto): ?User
    {
        $user = $this->userService->getConnectedUser();

        if ($dto->getEmail() !== $user->getEmail() && $dto->getEmail() != null) {
            $user->setEmail($dto->getEmail());
        }

        if ($dto->getPhone() !== $user->getPhone() && $dto->getPhone() != 0) {
            $user->setPhone($dto->getPhone());
        }

        if ($dto->getFullName() !== $user->getFullName()) {
            $user->setFullName($dto->getFullName());
        }

        $this->em->flush();

        return $user;
    }
}
