<?php

namespace App\Tests\Controller\Api\Subscription;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class PackControllerTest extends ApiTestCase
{
    public function testCreatePack(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/pack/create', ['json' => [
            'name' => 'Stater',
            'startedAt' => '2025-08-04T07:59:39.598Z',
            'expiredAt' => '2025-08-04T07:59:39.598Z',
            'price' => '51.00',
            'services' => [8, 5],
        ]]);

        $this->assertResponseStatusCodeSame(201);
    }
}
