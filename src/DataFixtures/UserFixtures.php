<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user->setEmail('user@domain.com')
            ->setUsername('main.user')
            ->setPassword($this->passwordHasher->hashPassword(
                $user,
                'Admin@123'
            ))
            ->setPhone($faker->phoneNumber())
            ->setFullName('Main User')
            ->setRoles(['ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setIsVerified(true);
        $manager->persist($user);

        $userAdmin = new User();
        $userAdmin->setEmail('admin@domain.com')
            ->setUsername('admin.user')
            ->setPassword($this->passwordHasher->hashPassword(
                $userAdmin,
                'Admin@123'
            ))
            ->setPhone($faker->phoneNumber())
            ->setFullName('Admin User')
            ->setRoles(['ROLE_ADMIN', 'ROLE_USER'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setIsVerified(true);
        $manager->persist($userAdmin);

        $manager->flush();
    }
}
