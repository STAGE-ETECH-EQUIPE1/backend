<?php

namespace App\Tests\Controller\Api\Auth;

use App\Entity\Auth\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

trait CreateTestUserTrait
{
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

        /** @var UserPasswordHasherInterface $passwordHasher */
        $passwordHasher = $this->container->get(UserPasswordHasherInterface::class);
        $user->setPassword(
            $passwordHasher->hashPassword($user, '$3CR3T')
        );

        /** @var EntityManagerInterface $manager */
        $manager = $this->container->get(EntityManagerInterface::class);
        $manager->persist($user);
        $manager->flush();

        return $user;
    }
}
