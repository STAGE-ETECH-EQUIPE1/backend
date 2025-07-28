<?php

namespace App\Tests\Repository\Auth;

use App\Factory\Auth\ClientFactory;
use App\Repository\Auth\ClientRepository;
use App\Repository\Auth\ResetPasswordRequestRepository;
use App\Tests\Repository\RepositoryTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ResetPasswordRequestRepositoryTest extends RepositoryTestCase
{
    use ResetDatabase;
    use Factories;

    /** @var string */
    protected $repositoryClass = ResetPasswordRequestRepository::class;

    public function testClientCount(): void
    {
        self::bootKernel();
        $this->assertEquals(0, $this->repository->count([]));
    }

}
