<?php

namespace App\Services\EditUser;

use App\DTO\User\UserDTO;
use App\Entity\Auth\User;

interface EditUserServiceInterface
{
    public function handle(UserDTO $dto): ?User;
}
