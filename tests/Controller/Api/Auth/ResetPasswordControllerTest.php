<?php

namespace App\Tests\Controller\Api\Auth;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Auth\User;
use Symfony\Component\DependencyInjection\Container;
use Zenstruck\Foundry\Test\ResetDatabase;

class ResetPasswordControllerTest extends ApiTestCase
{
    use ResetDatabase;
    protected Container $container;

    public function setUp(): void
    {
        parent::bootKernel();

        $this->container = self::getContainer();
    }

    public function testSendResetPasswordRequest(): void
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

        self::createClient([], [
            'base_uri' => $_ENV['TEST_BASE_URL'] ?? 'http://localhost',
        ])->request('POST', '/api/reset-password', [
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
