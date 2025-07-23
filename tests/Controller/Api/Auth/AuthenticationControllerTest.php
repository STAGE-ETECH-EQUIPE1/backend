<?php

namespace App\Tests\Controller\Api\Auth;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\DependencyInjection\Container;

class AuthenticationControllerTest extends ApiTestCase
{
    use ReloadDatabaseTrait;

    protected Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = static::getContainer();
    }

    protected function createTestUser(): User
    {
        $user = (new User())
            ->setEmail('test@example.com')
            ->setFullName('Test User')
            ->setPhone('0341234567')
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setIsVerified(true)
            ->setUsername('testuser');

        $user->setPassword(
            $this->container->get('security.user_password_hasher')->hashPassword($user, '$3CR3T')
        );

        $manager = $this->container->get('doctrine')->getManager();
        $manager->persist($user);
        $manager->flush();

        return $user;
    }

    public function testLogin(): void
    {
        $this->createTestUser();
        self::$alwaysBootKernel = false;

        $response = static::createClient([], [])->request('POST', '/api/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'test@example.com',
                'password' => '$3CR3T',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $json = $response->toArray();
        $this->assertArrayHasKey('token', $json);
    }

    public function testLoginFailure(): void
    {
        $this->createTestUser();
        self::$alwaysBootKernel = false;

        static::createClient([], [])->request('POST', '/api/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'test@example.com',
                'password' => 'WrongPassword',
            ],
        ]);

        self::$alwaysBootKernel = false;

        $this->assertResponseStatusCodeSame(401);
    }

    public function testRegister(): void
    {
        self::$alwaysBootKernel = false;

        $response = static::createClient([], [])->request('POST', '/api/register', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'user'.uniqid().'@gmail.com',
                'username' => 'testuser1',
                'password' => 'Password1234',
                'confirmPassword' => 'Password1234', // Fixed to match password
                'fullName' => 'Test User',
                'phone' => '0341234567',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $json = $response->toArray();
        $this->assertArrayHasKey('user', $json);
    }

    public function testConnectedUser(): void
    {
        $this->createTestUser();
        self::$alwaysBootKernel = false;

        $response = static::createClient([], [])->request('POST', '/api/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'test@example.com',
                'password' => '$3CR3T',
            ],
        ]);

        $token = $response->toArray()['token'];

        static::createClient([], [
            'base_uri' => $_ENV['TEST_BASE_URL'] ?? 'http://localhost',
        ])->request('GET', '/api/me', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }
}
