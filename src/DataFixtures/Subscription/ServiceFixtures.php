<?php

namespace App\DataFixtures\Subscription;

use App\DataFixtures\FakerTrait;
use App\Entity\Subscription\Service;
use App\Entity\Subscription\TypeService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ServiceFixtures extends Fixture implements DependentFixtureInterface
{
    use FakerTrait;

    public function load(ObjectManager $manager): void
    {
        $service = (new Service())
            ->setName('Branding')
            ->setPrice($this->getFaker()->randomFloat(1, 5, 100).'')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setTypeService(
                $this->getReference('type_service_'.$this->getFaker()->numberBetween(1, 5), TypeService::class)
            );
        $manager->persist($service);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TypeServiceFixtures::class,
        ];
    }
}
