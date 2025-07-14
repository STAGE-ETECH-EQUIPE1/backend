<?php

namespace App\Services\User;

use App\DTO\Request\UserRegistrationDTO;
use App\DTO\UserDTO;
use App\Entity\User;

interface UserServiceInterface
{
    /**
     * Convert UserRegistrationDTO to User entity.
     * @param UserRegistrationDTO $userDto
     * @return User
     */
    public function convertUserRegistrationDtoToUser(UserRegistrationDTO $userDto): User;

    /**
     * Convert User entity to UserDTO.
     * @param User $user
     * @return UserDTO
     */
    public function convertToDto(User $user): UserDTO;
}
