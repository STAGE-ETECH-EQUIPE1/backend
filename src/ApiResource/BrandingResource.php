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
        new Get(
            routeName: 'api_branding_submit_color_palettes'
        ),
        new Get(
            routeName: 'api_branding_submit_typographies'
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
        new Post(
            routeName: 'api_brandings_color_palettes'
        ),
        new Post(
            routeName: 'api_brandings_typographies'
        ),
        new Post(
            routeName: 'api_brandings_file_to_provide'
        ),
    ]
)]
class BrandingResource
{
}
