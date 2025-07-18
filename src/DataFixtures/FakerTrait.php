<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;

trait FakerTrait
{
    public function getFaker(): Generator
    {
        return Factory::create();
    }
}
