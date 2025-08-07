<?php

namespace App\Tests\Repository\Branding;

use App\Factory\Branding\BrandingProjectFactory;
use App\Factory\Branding\LogoVersionFactory;
use App\Repository\Branding\LogoVersionRepository;
use App\Tests\Repository\RepositoryTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class LogoVersionRepositoryTest extends RepositoryTestCase
{
    use ResetDatabase;
    use Factories;

    /** @var string */
    protected $repositoryClass = LogoVersionRepository::class;

    public function testLogoVersionCount(): void
    {
        self::bootKernel();
        LogoVersionFactory::createMany(10);
        $this->assertEquals(10, $this->repository->count([]));
    }

    public function testValidLogoFromBrandingCount(): void
    {
        self::bootKernel();
        BrandingProjectFactory::createMany(2);
        $this->assertEquals(10, $this->repository->count([]));
    }
}
