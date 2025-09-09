<?php

namespace App\Mapper\User;

use App\DTO\User\UserDTO;
use App\Request\User\UserRequest;

class UserMapper
{
    public static function fromRequest(UserRequest $request): UserDTO
    {
        return (new UserDTO())
            ->setEmail($request->getEmail())
            ->setPhone((string) $request->getPhone())
            ->setFullName($request->getFullName());
    }
}
