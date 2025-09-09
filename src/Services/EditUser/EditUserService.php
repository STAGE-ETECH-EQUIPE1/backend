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

    public function handle(UserDTO $dto): ?User
    {
        $user = $this->userService->getConnectedUser();

        $user->setUsername($dto->getEmail());
        $user->setPhone($dto->getPhone());
        $user->setFullName($dto->getFullName());

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
