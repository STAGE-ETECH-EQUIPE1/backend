<?php

namespace App\DataFixtures\Auth;

use App\DataFixtures\FakerTrait;
use App\Entity\Auth\Client;
use App\Entity\Auth\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture implements DependentFixtureInterface
{
    use FakerTrait;

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; ++$i) {
            $client = (new Client())
                ->setCompanyName($this->getFaker()->company())
                ->setUserInfo(
                    $this->getReference("client.user.$i", User::class)
                )
            ;
            $manager->persist($client);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}
