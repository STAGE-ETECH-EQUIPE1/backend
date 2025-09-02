<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;

#[ApiResource(
    operations: [
        new Post(
            routeName: 'api_secure_acceptance_checkout'
        ),
        new Post(
            routeName: 'api_payment_response'
        ),
        new Get(
            routeName: 'api_payment_resume'
        ),
    ]
)]
class PaymentResource
{
}
