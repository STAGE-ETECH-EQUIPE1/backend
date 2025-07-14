<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Controller\Api\RegistrationController;
use App\DTO\Output\JWT;
use App\DTO\Request\RegisterDTO;

#[ApiResource(
    shortName: 'Registration',
    operations: [
        new Post(
            uriTemplate: '/api/user/register',
            input: RegisterDTO::class,
            output: JWT::class,
            controller: RegistrationController::class
        ),
    ]
)]
class RegisterResource
{
}
