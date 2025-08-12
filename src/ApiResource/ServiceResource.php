<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;

#[ApiResource(
    operations: [
        new Post(
            routeName: 'api_create_service'
        ),
        new Get(
            routeName: 'api_show_service'
        ),
        new Put(
            routeName: 'api_edit_service'
        ),
    ]
)]
class ServiceResource
{
}