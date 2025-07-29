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

    private function getData(): array
    {
        return
        [
            ['code' => 'VISA-BASIC', 'name' => 'Assistance Visa Basique'],
            ['code' => 'VISA-PREMIUM', 'name' => 'Visa Premium (Accéléré)'],
            ['code' => 'BRANDING-LOGO', 'name' => 'Création de Logo'],
            ['code' => 'ECOMMERCE-STARTER', 'name' => 'Site E-Commerce Basique'],
            ['code' => 'STRATEGY-ANALYSIS', 'name' => 'Analyse de Marché'],
            ['code' => 'LEGAL-REG', 'name' => 'Immatriculation Société'],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach ($this->getData() as $data) {
            $service = (new Service())
                ->setName($data['name'])
                ->setPrice($this->getPrice())
                ->setCreatedAt($this->getDateTimeImmutable());
            $manager->persist($service);
            $this->addReference('service_'.$data['code'], $service);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
        ];
    }
}
