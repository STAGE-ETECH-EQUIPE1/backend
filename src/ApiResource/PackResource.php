<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;

#[ApiResource(
    operations: [
        new Post(
            routeName: 'api_create_pack'
        ),
        new Get(
            routeName: 'api_show_pack'
        ),
        new Put(
            routeName: 'api_edit_pack'
        ),
    ]
)]
class PackResource
{
}
