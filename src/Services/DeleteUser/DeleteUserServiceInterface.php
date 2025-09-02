<?php

namespace App\Services\DeleteUser;

use Symfony\Component\HttpFoundation\JsonResponse;

interface DeleteUserServiceInterface
{
    public function deleteUserById(int $id): JsonResponse;
}
