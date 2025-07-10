<?php

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;

use ApiPlatform\Metadata\Get;

#[ApiResource(
    operations: [
        new Get(uriTemplate: '/registerteste')
    ]
)]
class Teste
{
    public string $email;

    public string $phone;

    public string $fullName;
}