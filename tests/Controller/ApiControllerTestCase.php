<?php

namespace App\Tests\Controller;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Entity\Auth\User;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiControllerTestCase extends ApiTestCase
{
    protected Container $container;

    protected function setUp(): void
    {
        parent::setUp();
        $this->container = static::getContainer();
    }

    protected function apiClient(): Client
    {
        self::bootKernel();
        self::$alwaysBootKernel = true;

        return static::createClient();
    }

    protected function getAdminUser(): User
    {
        return (new User())
            ->setEmail('admin@domain.com')
            ->setPassword('Admin@123')
            ->setFullName('Test Admin User')
            ->setPhone('0341234567')
            ->setRoles(['ROLE_USER', 'ROLE_ADMIN'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setIsVerified(true)
            ->setUsername('test.user.admin');
    }

    protected function getClientUser(): User
    {
        $client = (new \App\Entity\Auth\Client())
            ->setCompanyName('Test Client Company')
            ->setCompanyArea('Area Company')
        ;

        return (new User())
            ->setEmail('client@domain.com')
            ->setPassword('Admin@123')
            ->setFullName('Test Client User')
            ->setPhone('0341234567')
            ->setRoles(['ROLE_USER', 'ROLE_CLIENT'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setIsVerified(true)
            ->setUsername('test.user.client')
            ->setClient($client)
        ;
    }

    private function persistUser(User $user): void
    {
        /** @var UserPasswordHasherInterface $passwordHasher */
        $passwordHasher = $this->container->get(UserPasswordHasherInterface::class);
        $user->setPassword(
            $passwordHasher->hashPassword($user, (string) $user->getPassword())
        );

        $this->saveEntity($user);
    }

    protected function createAdminUser(): User
    {
        $user = $this->getAdminUser();
        $this->persistUser($user);

        return $user;
    }

    protected function createClientUser(): User
    {
        $user = $this->getClientUser();
        $this->persistUser($user);

        return $user;
    }

    protected function authenticateClient(): ResponseInterface
    {
        $this->createClientUser();

        return $this->apiClient()->request('POST', '/api/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'client@domain.com',
                'password' => 'Admin@123',
            ],
        ]);
    }

    protected function authenticateAdmin(): ResponseInterface
    {
        $this->createAdminUser();

        return $this->apiClient()->request('POST', '/api/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'admin@domain.com',
                'password' => 'Admin@123',
            ],
        ]);
    }

    protected function saveEntity(object $entity): void
    {
        /** @var EntityManagerInterface $manager */
        $manager = $this->container->get(EntityManagerInterface::class);
        $manager->persist($entity);
        $manager->flush();
    }

    public function getFaker(): Generator
    {
        return Factory::create('fr_FR');
    }
}
