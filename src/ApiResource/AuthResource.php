<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Auth\RegisterController;
use App\DTO\Request\UserRegistrationDTO;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/register',
            controller: RegisterController::class,
            input: UserRegistrationDTO::class,
        ),
        new Post(
            routeName: 'api_reset_password'
        ),
        new Post(
            routeName: 'api_send_reset_password'
        ),
        new Post(
            routeName: 'api_auth_google'
        ),
    ]
)]
class AuthResource
{
}
