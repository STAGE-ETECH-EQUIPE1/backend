<?php

namespace App\Tests\Controller\Logo;

use App\Entity\Branding\LogoVersion;
use App\Factory\Branding\LogoVersionFactory;
use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetLogoFeedBacksControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;

    public function testValidFeedBackSender(): void
    {
        $token = $this->authenticateClient()->toArray()['token'];

        /** @var LogoVersion $logo */
        $logo = LogoVersionFactory::createOne();
        $logoId = (int) $logo->getId();

        $this->apiClient()->request('GET', "/api/logo/$logoId/feedbacks", [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token",
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }
}
