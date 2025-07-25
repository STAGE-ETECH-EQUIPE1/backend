<?php

namespace App\Tests\Controller\Api\Auth;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Symfony\Component\DependencyInjection\Container;
use Zenstruck\Foundry\Test\ResetDatabase;

class ResetPasswordControllerTest extends ApiTestCase
{
    use ResetDatabase;
    use CreateTestUserTrait;

    protected Container $container;

    public function setUp(): void
    {
        parent::bootKernel();

        $this->container = self::getContainer();
    }

    public function testSendResetPasswordRequest(): void
    {
        $user = $this->createTestUser();

        self::$alwaysBootKernel = false;
        self::createClient([], [])
            ->request('POST', '/api/reset-password', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'email' => $user->getEmail(),
                ],
            ]);

        $this->assertResponseIsSuccessful();
    }
}
