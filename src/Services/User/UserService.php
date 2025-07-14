<?php

namespace App\Services\User;

use App\DTO\Output\JWTUser;
use App\DTO\Request\UserRegistrationDTO;
use App\DTO\UserDTO;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function convertUserRegistrationDtoToUser(UserRegistrationDTO $userDto): User
    {
        $user = new User();
        $user->setEmail($userDto->email)
            ->setUsername($userDto->username)
            ->setFullName($userDto->fullName)
            ->setPhone($userDto->phone)
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                $userDto->password
            ));

        return $user;
    }

    public function convertToDto(User $user): UserDTO
    {
        return (new UserDTO())
            ->setId((int) $user->getId())
            ->setEmail((string) $user->getEmail())
            ->setUsername((string) $user->getUsername())
            ->setFullName((string) $user->getFullName())
            ->setPhone((string) $user->getPhone())
            ->setCreatedAt($user->getCreatedAt() ?? new \DateTimeImmutable());
    }

    public function convertToJwtUser(User $user): JWTUser
    {
        return new JWTUser(
            $user->getUsername() ?? '',
            $user->getEmail(),
            $user->getRoles()
        );
    }
}
