<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;

#[ApiResource(
    operations: [
        new Get(
            routeName: 'api_client_form_connected_user'
        ),
        new Get(
            routeName: 'api_current_user'
        ),
    ]
)]
class UserResource
{
}
