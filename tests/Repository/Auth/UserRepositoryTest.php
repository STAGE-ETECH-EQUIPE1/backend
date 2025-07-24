<?php

namespace App\Tests\Repository\Auth;

use App\Factory\Auth\UserFactory;
use App\Repository\Auth\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UserRepositoryTest extends KernelTestCase
{
    use ResetDatabase;
    use Factories;

    public function testUserCount(): void
    {
        self::bootKernel();
        UserFactory::createMany(10);
        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);
        $this->assertEquals(10, $userRepository->count([]));
    }
}
