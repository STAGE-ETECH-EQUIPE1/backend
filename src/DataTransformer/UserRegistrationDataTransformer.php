<?php

namespace App\DataTransformer;

use App\DTO\Request\UserRegistrationDTO;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegistrationDataTransformer
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function transform(UserRegistrationDTO $userRegistrationDto, User $user): User
    {
        $user->setEmail($userRegistrationDto->email);
        $user->setPassword($this->passwordHasher->hashPassword(
            $user,
            $userRegistrationDto->password
        ));
        $user->setRoles(['ROLE_USER']);

        return $user;
    }
}
