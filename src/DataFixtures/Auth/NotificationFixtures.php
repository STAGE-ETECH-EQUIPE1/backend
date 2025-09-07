<?php

namespace App\DataFixtures\Auth;

use App\DataFixtures\FakerTrait;
use App\Entity\Auth\Notification;
use App\Entity\Auth\User;
use App\Enum\NotificationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class NotificationFixtures extends Fixture implements DependentFixtureInterface
{
    use FakerTrait;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; ++$i) {
            for ($j = 0; $j <= 2; ++$j) {
                $notification = (new Notification())
                    ->setContent($this->getFaker()->sentence())
                    ->setCreatedAt($this->getDateTimeImmutable())
                    ->setType(NotificationType::SUCCESS)
                    ->setOwner($this->getReference("client.user.$i", User::class))
                ;
                $manager->persist($notification);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ClientFixtures::class,
        ];
    }
}
