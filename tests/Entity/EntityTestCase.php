<?php

namespace App\Tests\Entity;

use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EntityTestCase extends KernelTestCase
{
    public function getFaker(): Generator
    {
        return Factory::create('fr_FR');
    }

    public function persistEntity(object $entity): void
    {
        self::bootKernel();
        /** @var EntityManagerInterface $manager */
        $manager = static::getContainer()->get(EntityManagerInterface::class);
        $manager->persist($entity);
        $manager->flush();
    }
}
