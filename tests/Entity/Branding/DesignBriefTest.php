<?php

namespace App\Tests\Entity\Branding;

use App\Entity\Branding\DesignBrief;
use App\Factory\Branding\DesignBriefFactory;
use App\Tests\Entity\EntityTestCase;
use App\Tests\Trait\ValidationTestTrait;
use Zenstruck\Foundry\Test\Factories;

class DesignBriefTest extends EntityTestCase
{
    use ValidationTestTrait;
    use Factories;

    public function getEntity(): DesignBrief
    {
        return DesignBriefFactory::createOne();
    }

    public function testValidEntity(): void
    {
        $this->assertHasErrors($this->getEntity());
    }
}
