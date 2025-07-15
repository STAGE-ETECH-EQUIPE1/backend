<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthenticationTest extends WebTestCase
{
    public function testRegisterAndLogin(): void
    {
        $client = static::createClient();
        $email = 'user'.uniqid().'@gmail.com';
        $client->request('POST', '/api/register', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json',
        ], json_encode([
            'email' => $email,
            'username' => 'testuser',
            'password' => 'Password123',
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
            'password' => 'Password123',
        ]));
        $this->assertResponseIsSuccessful();
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('token', $data);
        $token = $data['token'];

        $client->request('GET', '/api/me', [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer '.$token,
        ]);
        $this->assertResponseIsSuccessful();
        $meData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('data', $meData);
        $this->assertArrayHasKey('email', $meData['data']);
        $this->assertSame($email, $meData['data']['email']);
    }

    public function testLoginWithWrongPassword(): void
    {
        $client = static::createClient();
        $email = 'user'.uniqid().'@gmail.com';
        $client->request('POST', '/api/register', [], [], [
            'CONTENT_TYPE' => 'application/ld+json',
            'HTTP_ACCEPT' => 'application/ld+json',
        ], json_encode([
            'email' => $email,
            'username' => 'testuser',
            'password' => 'Password123',
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
            'password' => 'WrongPassword',
        ]));

        $this->assertResponseStatusCodeSame(401);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $content);
        $this->assertStringContainsString('invalid credentials', strtolower($content['message']));
    }
}
