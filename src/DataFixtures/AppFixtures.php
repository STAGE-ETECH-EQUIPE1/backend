<?php

namespace App\DataFixtures;

use App\DataFixtures\Payment\PaymentMethodFixtures;
use App\DataFixtures\Subscription\PackFixtures;
use App\DataFixtures\Subscription\ServiceFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ServiceFixtures::class,
            PackFixtures::class,
            PaymentMethodFixtures::class,
            // SubscriptionFixtures::class,
        ];
    }
}
