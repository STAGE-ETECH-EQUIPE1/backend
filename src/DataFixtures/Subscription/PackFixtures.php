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
                'code' => 'DUBAI-STARTER',
                'name' => 'Pack Dubai Starter',
                'services' => ['VISA-BASIC', 'ECOMMERCE-STARTER', 'LEGAL-REG'],
            ],
            [
                'code' => 'DUBAI-PRO',
                'name' => 'Pack Dubai Pro',
                'services' => ['VISA-PREMIUM', 'ECOMMERCE-STARTER', 'LEGAL-REG', 'BRANDING-LOGO'],
            ],
            [
                'code' => 'GLOBAL-EXPANSION',
                'name' => 'Pack Expansion Globale',
                'services' => ['VISA-PREMIUM', 'STRATEGY-ANALYSIS', 'BRANDING-LOGO', 'LEGAL-REG'],
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
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
            $this->addReference('pack_'.$data['code'], $pack);
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
