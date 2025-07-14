<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Api\CurrentUserController;
use App\Controller\Api\UserRegistrationController;
use App\DTO\Request\UserRegistrationDTO;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/register',
            controller: UserRegistrationController::class,
            input: UserRegistrationDTO::class,
            name: 'register',
            description: 'Register a new user'
        ),
        new Post(
            uriTemplate: '/me',
            controller: CurrentUserController::class,
            input: false,
            name: 'current_user',
            description: 'Get the current authenticated user'
        ),
    ]
)]
final class UserAuthentication
{
}
