<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;

#[ApiResource(
    operations: [
        new Get(
            routeName: 'api_branding_project_logos'
        ),
        new GetCollection(
            routeName: 'api_branding_user_projects'
        ),
        new Post(
            routeName: 'api_branding_logo_brief'
        ),
        new Post(
            routeName: 'api_branding_project_submit'
        ),
    ]
)]
class BrandingResource
{
}
