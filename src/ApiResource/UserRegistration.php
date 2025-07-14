<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Api\UserRegistrationController;
use App\DTO\Request\UserRegistrationDTO;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/register',
            controller: UserRegistrationController::class,
            input: UserRegistrationDTO::class,
            name: 'register'
        ),
    ]
)]
final class UserRegistration
{
}
