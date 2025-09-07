<?php

namespace App\Tests\Controller\Service;

use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateServiceControllerTest extends ApiControllerTestCase
{
    use Factories;
    use ResetDatabase;

    public function testCreateService(): void
    {
        $token = $this->authenticateAdmin()->toArray()['token'];

        $this->apiClient()->request('POST', '/api/service/create', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token",
            ], 'json' => [
                'name' => 'testName',
                'price' => '25.2',
            ]]);
        $this->assertResponseStatusCodeSame(201);
    }
}
