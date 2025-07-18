<?php

namespace App\DataFixtures\Subscription;

use App\DataFixtures\FakerTrait;
use App\Entity\Subscription\Pack;
use App\Entity\Subscription\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PackFixtures extends Fixture implements DependentFixtureInterface
{
    use FakerTrait;

    private function getData(): array
    {
        return [
            [
                'name' => 'Pack Dubai Starter',
                'services' => ['VISA-BASIC', 'ECOMMERCE-STARTER', 'LEGAL-REG'],
            ],
            [
                'name' => 'Pack Dubai Pro',
                'services' => ['VISA-PREMIUM', 'ECOMMERCE-STARTER', 'LEGAL-REG', 'BRANDING-LOGO'],
            ],
            [
                'name' => 'Pack Expansion Globale',
                'services' => ['VISA-PREMIUM', 'STRATEGY-ANALYSIS', 'BRANDING-LOGO', 'LEGAL-REG'],
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        $i = 1;
        foreach ($this->getData() as $data) {
            $startedAt = $this->getDateTimeImmutable();

            $pack = (new Pack())
                ->setName($data['name'])
                ->setPrice($this->getPrice())
                ->setStartedAt($startedAt)
                ->setExpiredAt($startedAt->modify('+30 days'))
                ->setCreatedAt($this->getDateTimeImmutable());
            foreach ($data['services'] as $serviceCode) {
                $pack->addService(
                    $this->getReference("service_$serviceCode", Service::class)
                );
            }

            $manager->persist($pack);
            $this->addReference("pack_$i", $pack);
            ++$i;
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ServiceFixtures::class,
            TypeServiceFixtures::class,
        ];
    }
}
