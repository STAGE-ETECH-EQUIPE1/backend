<?php

namespace App\Services\User;

use App\DTO\User\UserDTO;
use App\Entity\Auth\User;
use App\Request\Auth\UserRegistrationRequest;
use App\Response\JWTUser;

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
    public function convertUserRegistrationDtoToUser(UserRegistrationRequest $userDto): User;

    /**
     * Convert User entity to UserDTO.
     */
    public function convertToDto(User $user): UserDTO;

    /**
     * Summary of convertToJwtUser.
     */
    public function convertToJwtUser(User $user): JWTUser;
}
