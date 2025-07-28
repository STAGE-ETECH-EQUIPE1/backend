<?php

namespace App\Tests\Entity\Auth;

use App\Entity\Auth\Client;
use App\Factory\Auth\UserFactory;
use App\Tests\DTO\ValidationTestTrait;
use App\Tests\Entity\EntityTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ClientTest extends EntityTestCase
{
    use Factories;
    use ValidationTestTrait;

    public function getEntity(): Client
    {
        return (new Client())
            ->setCompanyName($this->getFaker()->company())
            ->setUserInfo(UserFactory::new()->create())
        ;
    }

    public function testValidEntity(): void
    {
        $this->assertHasErrors($this->getEntity());
    }
}
