<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Request\Auth\ResetPasswordRequest;
use App\Request\Auth\UserRegistrationRequest;

#[ApiResource(
    operations: [
        new Post(
            routeName: 'api_register_user',
            input: UserRegistrationRequest::class
        ),
        new Post(
            routeName: 'api_reset_password',
        ),
        new Post(
            routeName: 'api_send_reset_password',
            input: ResetPasswordRequest::class
        ),
        new Post(
            routeName: 'api_auth_google'
        ),
    ]
)]
class AuthResource
{
}
