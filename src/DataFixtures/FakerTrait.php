<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;

trait FakerTrait
{
    public function getFaker(): Generator
    {
        return Factory::create('fr_FR');
    }

    public function numberBetween(int $min, int $max): int
    {
        return $this->getFaker()->unique(true)->numberBetween($min, $max);
    }

    public function getPrice(): string
    {
        return $this->getFaker()->randomFloat(2, 10, 5000).'';
    }

    public function getDateTimeImmutable(): \DateTimeImmutable
    {
        return \DateTimeImmutable::createFromMutable($this->getFaker()->dateTimeThisYear('now'));
    }
}
