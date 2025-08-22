<?php

namespace App\Tests\Controller\Auth;

use App\Tests\Controller\ApiControllerTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\ResetDatabase;

class SecurityControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;

    public function testLogin(): void
    {
        $this->createAdminUser();

        $response = $this->apiClient()->request('POST', '/api/login', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'email' => 'admin@domain.com',
                'password' => 'Admin@123',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $json = $response->toArray();
        $this->assertArrayHasKey('token', $json);
    }

    public function testLoginFailure(): void
    {
        $this->createAdminUser();

        $this->apiClient()->request('POST', '/api/login', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'email' => 'admin@domain.com',
                'password' => 'WrongPassword',
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);
    }
}
