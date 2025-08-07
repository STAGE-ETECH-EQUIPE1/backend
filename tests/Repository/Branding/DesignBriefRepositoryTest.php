<?php

namespace App\Tests\Repository\Branding;

use App\Factory\Branding\DesignBriefFactory;
use App\Repository\Branding\DesignBriefRepository;
use App\Tests\Repository\RepositoryTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DesignBriefRepositoryTest extends RepositoryTestCase
{
    use ResetDatabase;
    use Factories;

    /** @var string */
    protected $repositoryClass = DesignBriefRepository::class;

    public function testCountDesignBriefs(): void
    {
        self::bootKernel();
        DesignBriefFactory::createMany(10);
        $this->assertEquals(10, $this->repository->count([]));
    }
}
