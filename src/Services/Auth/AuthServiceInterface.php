<?php

namespace App\Services\Auth;

use App\DTO\Request\UpdatePasswordDTO;

interface AuthServiceInterface
{
    /**
     * Send email to reset password.
     */
    public function sendResetPasswordEmail(string $email): void;

    /**
     * Update password from token.
     */
    public function updateUserPassword(string $token, UpdatePasswordDTO $updatePasswordDTO): void;
}
