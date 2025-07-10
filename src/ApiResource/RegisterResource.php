<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;

use ApiPlatform\Metadata\Post;

// #[ApiResource(
//     operations: [
//         new Post(uriTemplate: '/register')
//     ]
// )]
class RegisterResource
{
    public string $email;

    public string $phone;

    public string $fullName;
}