<?php

namespace App\DataFixtures\Subscription;

use App\DataFixtures\Auth\UserFixtures as AuthUserFixtures;
use App\DataFixtures\FakerTrait;
use App\Entity\Subscription\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture implements DependentFixtureInterface
{
    use FakerTrait;

    public function load(ObjectManager $manager): void
    {
        $startedAt = $this->getDateTimeImmutable();

        $subscription = (new Subscription())
            ->setCreatedAt($startedAt)
            ->setStartedAt($startedAt)
            ->setEndedAt($startedAt->modify('+30 days'))
        ;
    }

    public function getDependencies(): array
    {
        return [
            ServiceFixtures::class,
            PackFixtures::class,
            AuthUserFixtures::class,
        ];
    }
}
