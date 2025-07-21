<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UsersTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testGetCollection(): void
    {
        UserFactory::createMany(10);

        $response = static::createClient()->request('GET', '/users');
    }
}
