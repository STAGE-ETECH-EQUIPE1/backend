<?php

namespace App\Tests\Authentication;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterTest extends WebTestCase
{
    public function testRegister(): void
    {
        $client = static::createClient();
        $email = 'user'.uniqid().'@gmail.com';
        $client->request('POST', '/api/register', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HPTTP_ACCEPT' => 'application/ld+json',
        ], json_encode([
            'email' => $email,
            'username' => 'testuser1',
            'password' => 'Password1234',
            'confirmPassword' => 'Password123',
            'fullName' => 'Test User',
            'phone' => '0341234567',
        ]));
        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($client->getResponse()->getContent());
    }
}
