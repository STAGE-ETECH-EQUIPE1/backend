<?php

namespace App\Tests\Controller\Auth;

use App\Tests\Controller\ApiControllerTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\ResetDatabase;

class RegisterControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;

    public function testRegister(): void
    {
        $response = $this->apiClient()->request('POST', '/api/register', [
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                'email' => 'user'.uniqid().'@gmail.com',
                'username' => 'testuser1',
                'password' => 'Password1234',
                'confirmPassword' => 'Password1234',
                'fullName' => 'Test User',
                'phone' => '0341234567',
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $json = $response->toArray();
        $this->assertArrayHasKey('user', $json);
    }
}
