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
        $companyAreas = [
            'health', 'industry', 'sports', 'healthcare',
        ];

        $adminClient = (new Client())
            ->setCompanyName($this->getFaker()->company())
            ->setUserInfo(
                $this->getReference('admin.client', User::class)
            )
        ;
        $manager->persist($adminClient);

        for ($i = 1; $i <= 10; ++$i) {
            $client = (new Client())
                ->setCompanyName($this->getFaker()->company())
                ->setCompanyArea($companyAreas[array_rand($companyAreas)])
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
