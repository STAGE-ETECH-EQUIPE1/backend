<?php

namespace App\Tests\Authentication;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testLogin(): void
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

        $client->request('POST', '/api/login', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
        ], json_encode([
            'email' => $email,
            'password' => 'Password1234',
        ]));
        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $data);
    }
}
