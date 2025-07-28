<?php

namespace App\Tests\Entity\Branding;

use App\Entity\Branding\BrandingProject;
use App\Enum\BrandingStatus;
use App\Factory\Auth\ClientFactory;
use App\Tests\DTO\ValidationTestTrait;
use App\Tests\Entity\EntityTestCase;
use Zenstruck\Foundry\Test\Factories;

class BrandingProjectTest extends EntityTestCase
{
    use ValidationTestTrait;
    use Factories;

    public function getEntity(): BrandingProject
    {
        return (new BrandingProject())
            ->setCreatedAt((new \DateTimeImmutable())::createFromMutable($this->getFaker()->dateTimeThisYear('now')))
            ->setUpdatedAt((new \DateTimeImmutable())::createFromMutable($this->getFaker()->dateTimeThisYear('now')))
            ->setClient(ClientFactory::new()->create())
            ->setName($this->getFaker()->realText(50))
            ->setDescription($this->getFaker()->paragraph())
            ->setStatus(BrandingStatus::ACTIVE)
            ->setDeadLine((new \DateTimeImmutable())::createFromMutable($this->getFaker()->dateTimeThisYear('+1 month')))
        ;
    }

    public function testValidEntity(): void
    {
        $this->assertHasErrors($this->getEntity());
    }
}
