<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;

#[ApiResource(
    operations: [
        new Post(
            routeName: 'api_create_pack'
        ),
    ]
)]
class PackResource
{
}