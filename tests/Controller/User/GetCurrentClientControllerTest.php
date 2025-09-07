<?php

namespace App\Tests\Controller\User;

use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetCurrentClientControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;

    public function testValidCurrentCLient(): void
    {
        $response = $this->authenticateClient();

        $token = $response->toArray()['token'];

        $this->apiClient()->request('GET', '/api/client/me', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testInvalidCurrentClient(): void
    {
        $response = $this->authenticateAdmin();

        $token = $response->toArray()['token'];

        $response = $this->apiClient()->request('GET', '/api/client/me', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $message = $response->toArray()['message'];

        $this->assertEquals($message, 'no client is not associated with the user.');
    }
}
