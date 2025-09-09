<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;

#[ApiResource(
    operations: [
        new Post(
            routeName: 'api_logo_comment'
        ),
        new GetCollection(
            routeName: 'api_logo_feedback_list'
        ),
    ]
)]
class LogoResource
{
}
