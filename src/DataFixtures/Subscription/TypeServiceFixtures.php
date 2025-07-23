<?php

namespace App\DataFixtures\Subscription;

use App\Entity\Subscription\TypeService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; ++$i) {
            $typeService = (new TypeService())
                ->setName("Type Service $i");
            $manager->persist($typeService);
            $this->addReference("type_service_$i", $typeService);
        }

        $manager->flush();
    }
}
