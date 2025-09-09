<?php

namespace App\Tests\Controller\User;

use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetCurrentUserControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;

    public function testConnectedUser(): void
    {
        $response = $this->authenticateAdmin();

        $token = $response->toArray()['token'];

        $this->apiClient()->request('GET', '/api/me', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }
}
