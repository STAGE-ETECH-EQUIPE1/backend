<?php

namespace App\DataFixtures\Subscription;

use App\DataFixtures\Auth\UserFixtures as AuthUserFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
    }

    public function getDependencies(): array
    {
        return [
            PackFixtures::class,
            AuthUserFixtures::class,
        ];
    }
}
