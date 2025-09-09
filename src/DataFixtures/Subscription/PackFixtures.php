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
                'name' => 'Pack Free',
                'price' => 0,
                'services' => ['CREATION-LOGO-FREE', 'CREATION-COMPANY-NAME-FREE', 'CREATION-VALUES-FREE', 'CREATION-TON-VOICE-FREE', 'CREATION-TYPOGRAPHIE-FREE'],
            ],
            [
                'name' => 'Pack Premium',
                'price' => 20,
                'services' => ['CREATION-LOGO', 'CREATION-COMPANY-NAME', 'CREATION-VALUES', 'CREATION-TON-VOICE', 'CREATION-TYPOGRAPHIE'],
            ],
            [
                'name' => 'Pack VIP',
                'price' => 30,
                'services' => ['CREATION-LOGO', 'CREATION-COMPANY-NAME', 'CREATION-VALUES', 'CREATION-TON-VOICE', 'CREATION-TYPOGRAPHIE'],
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
                ->setPrice($data['price'])
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
        ];
    }
}
