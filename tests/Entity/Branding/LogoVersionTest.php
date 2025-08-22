<?php

namespace App\Tests\Entity\Branding;

use App\Entity\Branding\LogoVersion;
use App\Factory\Branding\LogoVersionFactory;
use App\Tests\Entity\EntityTestCase;
use App\Tests\Trait\ValidationTestTrait;
use Zenstruck\Foundry\Test\Factories;

class LogoVersionTest extends EntityTestCase
{
    use ValidationTestTrait;
    use Factories;

    public function getEntity(): LogoVersion
    {
        return LogoVersionFactory::createOne();
    }

    public function testValidEntity(): void
    {
        $this->assertHasErrors($this->getEntity());
    }
}
