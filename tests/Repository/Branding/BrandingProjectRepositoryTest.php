<?php

namespace App\Tests\Repository\Branding;

use App\Factory\Branding\BrandingProjectFactory;
use App\Repository\Branding\BrandingProjectRepository;
use App\Tests\Repository\RepositoryTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class BrandingProjectRepositoryTest extends RepositoryTestCase
{
    use ResetDatabase;
    use Factories;

    /** @var string */
    protected $repositoryClass = BrandingProjectRepository::class;

    public function testBrandingProjectCount(): void
    {
        self::bootKernel();
        BrandingProjectFactory::createMany(10);
        $this->assertEquals(10, $this->repository->count([]));
    }
}
