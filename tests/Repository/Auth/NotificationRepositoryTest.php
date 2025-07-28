<?php

namespace App\Tests\Repository\Auth;

use App\Factory\Auth\NotificationFactory;
use App\Repository\Auth\NotificationRepository;
use App\Tests\Repository\RepositoryTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class NotificationRepositoryTest extends RepositoryTestCase
{
    use ResetDatabase;
    use Factories;

    /** @var string */
    protected $repositoryClass = NotificationRepository::class;

    public function testUserCount(): void
    {
        self::bootKernel();
        NotificationFactory::createMany(10);
        $this->assertEquals(10, $this->repository->count([]));
    }
}
