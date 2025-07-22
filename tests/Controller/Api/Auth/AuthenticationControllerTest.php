<?php

namespace App\Tests\Controller\Api\Auth;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthenticationControllerTest extends WebTestCase
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

    public function testLoginFailure(): void
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
            'password' => 'WronfPassword',
        ]));
        $this->assertResponseStatusCodeSame(401);
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $content);
        $this->assertStringContainsString('invalid credentials', strtolower($content['message']));
    }

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
