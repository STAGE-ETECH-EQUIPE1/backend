<?php

namespace App\Tests\Controller\Api\Subscription;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ServiceControllerTest extends ApiTestCase
{
    public function testCreateService(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/service/create', ['json' => [
            'name' => 'testName',
            'price' => '25.2',
            
        ]]);
        $this->assertResponseStatusCodeSame(201);
    }
    
}