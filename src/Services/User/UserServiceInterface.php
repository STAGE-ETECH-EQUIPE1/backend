<?php

namespace App\Services\User;

use App\DTO\Output\JWTUser;
use App\DTO\Request\UserRegistrationDTO;
use App\DTO\UserDTO;
use App\Entity\Auth\User;

interface UserServiceInterface
{
    /**
     * Get User by ID.
     */
    public function getById(int $id): User;

    /**
     * Get User by email.
     */
    public function getByEmail(string $email): User;

    /**
     * Get User from security.
     */
    public function getConnectedUser(): User;

    /**
     * Convert UserRegistrationDTO to User entity.
     */
    public function convertUserRegistrationDtoToUser(UserRegistrationDTO $userDto): User;

    /**
     * Convert User entity to UserDTO.
     */
    public function convertToDto(User $user): UserDTO;

    /**
     * Summary of convertToJwtUser.
     */
    public function convertToJwtUser(User $user): JWTUser;
}
