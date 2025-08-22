<?php

namespace App\Services\Auth;

use App\Request\Auth\UpdatePasswordRequest;

interface AuthServiceInterface
{
    /**
     * Send an email to verify the user's email address.
     */
    public function sendVerificationEmail(string $email): void;

    /**
     * Send email to reset password.
     */
    public function sendResetPasswordEmail(string $email): void;

    /**
     * Update password from token.
     */
    public function updateUserPassword(string $token, UpdatePasswordRequest $updatePasswordDTO): void;
}
