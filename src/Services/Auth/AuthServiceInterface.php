<?php

namespace App\Services\Auth;

use App\Entity\Auth\User;
use App\Request\Auth\UpdatePasswordRequest;
use App\Request\Auth\UserRegistrationRequest;

interface AuthServiceInterface
{
    /**
     * Register user.
     */
    public function registerUser(UserRegistrationRequest $request): User;

    /**
     * Send email to reset password.
     */
    public function sendResetPasswordEmail(string $email): void;

    /**
     * Update password from token.
     */
    public function updateUserPassword(string $token, UpdatePasswordRequest $updatePasswordDTO): void;
}
