<?php

namespace App\Tests\Controller\Auth;

use App\Tests\Controller\ApiControllerTestCase;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\ResetDatabase;

class SendResetPasswordControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;

    public function testValidSendResetPasswordRequest(): void
    {
        $this->createAdminUser();

        $this->apiClient()->request('POST', '/api/reset-password', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'email' => $this->getAdminUser()->getEmail(),
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testNoUserSendPassword(): void
    {
        $this->apiClient()->request('POST', '/api/reset-password', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'email' => $this->getAdminUser()->getEmail(),
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testSendManyTimeEmailSend(): void
    {
        $this->createAdminUser();

        $this->apiClient()->request('POST', '/api/reset-password', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'email' => $this->getAdminUser()->getEmail(),
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $this->apiClient()->request('POST', '/api/reset-password', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'email' => $this->getAdminUser()->getEmail(),
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
