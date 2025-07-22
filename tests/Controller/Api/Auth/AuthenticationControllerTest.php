<?php

namespace App\Tests\Controller\Api\Auth;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\DependencyInjection\Container;

class AuthenticationControllerTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    protected Client $client;

    protected Container $container;

    public function setUp(): void
    {
        $this->client = self::createClient([], [
            'base_uri' => $_ENV['TEST_BASE_URL'] ?? 'http://localhost',
        ]);
        $this->container = self::getContainer();
    }

    public function testLogin(): void
    {
        $user = (new User())
            ->setEmail('test@example.com')
            ->setFullName('Test User')
            ->setPhone('0341234567')
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setIsVerified(true)
            ->setUsername('testuser')
        ;
        $user->setPassword(
            $this->container->get('security.user_password_hasher')->hashPassword($user, '$3CR3T')
        );

        $manager = $this->container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        $savedUser = $manager->getRepository(User::class)->findOneBy(['email' => 'test@example.com']);
        $this->assertNotNull($savedUser, 'User was not saved to database');

        $isValid = $this->container->get('security.user_password_hasher')
            ->isPasswordValid($user, '$3CR3T');
        $this->assertTrue($isValid, 'Password hashing verification failed');

        // retrieve a token
        $response = $this->client->request('POST', '/api/login', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'email' => 'test@example.com',
                'password' => '$3CR3T',
            ],
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $json);

        // test not authorized
        // $client->request('GET', '/greetings');
        // $this->assertResponseStatusCodeSame(401);

        // test authorized
        // $client->request('GET', '/greetings', ['auth_bearer' => $json['token']]);
        // $this->assertResponseIsSuccessful();

        $this->client->request('POST', '/api/login', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'email' => 'test@example.com',
                'password' => 'WronfPassword',
            ],
        ]);

        $this->assertResponseStatusCodeSame(401);
    }

    public function testRegister(): void
    {
        $response = $this->client->request('POST', '/api/register', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'email' => 'user'.uniqid().'@gmail.com',
                'username' => 'testuser1',
                'password' => 'Password1234',
                'confirmPassword' => 'Password123',
                'fullName' => 'Test User',
                'phone' => '0341234567',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJson($response->getContent());

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('user', $json);
    }

    public function testConnectedUser(): void
    {
        $user = (new User())
            ->setEmail('test@example.com')
            ->setFullName('Test User')
            ->setPhone('0341234567')
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setIsVerified(true)
            ->setUsername('testuser')
        ;
        $user->setPassword(
            $this->container->get('security.user_password_hasher')->hashPassword($user, '$3CR3T')
        );

        $manager = $this->container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        $savedUser = $manager->getRepository(User::class)->findOneBy(['email' => 'test@example.com']);
        $this->assertNotNull($savedUser, 'User was not saved to database');

        $isValid = $this->container->get('security.user_password_hasher')
            ->isPasswordValid($user, '$3CR3T');
        $this->assertTrue($isValid, 'Password hashing verification failed');

        // retrieve a token
        $response = $this->client->request('POST', '/api/login', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'email' => 'test@example.com',
                'password' => '$3CR3T',
            ],
        ]);

        $json = $response->toArray();
        $this->assertResponseIsSuccessful();
        $this->assertArrayHasKey('token', $json);

        $response = $this->client->request('GET', '/api/me', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$this->client->getResponse()->toArray()['token'],
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }
}
