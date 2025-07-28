<?php

namespace App\Tests\Repository\Auth;

use App\Factory\Auth\ClientFactory;
use App\Repository\Auth\ClientRepository;
use App\Tests\Repository\RepositoryTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ClientRepositoryTest extends RepositoryTestCase
{
    use ResetDatabase;
    use Factories;

    /** @var string */
    protected $repositoryClass = ClientRepository::class;

    public function testClientCount(): void
    {
        self::bootKernel();
        ClientFactory::createMany(10);
        $this->assertEquals(10, $this->repository->count([]));
    }
}
