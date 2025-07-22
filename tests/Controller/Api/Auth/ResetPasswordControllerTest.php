<?php

namespace App\Tests\Controller\Api\Auth;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\User;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Component\DependencyInjection\Container;

class ResetPasswordControllerTest extends ApiTestCase
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

    public function sendResetPasswordRequest(): void
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

        $this->client->request('POST', '/api/reset-password', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'email' => $user->getEmail(),
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }
}
