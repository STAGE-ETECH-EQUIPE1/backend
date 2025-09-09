<?php

namespace App\Tests\Controller\Logo;

use App\Entity\Branding\LogoVersion;
use App\Factory\Branding\LogoVersionFactory;
use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CommentLogoControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;
    use Factories;

    public function testValidCommentLogoById(): void
    {
        /** @var LogoVersion $logo */
        $logo = LogoVersionFactory::createOne();
        $logoId = (int) $logo->getId();

        $token = $this->authenticateClient()->toArray()['token'];

        $this->apiClient()->request('POST', "/api/logo/{$logoId}/comment", [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ],
            'json' => [
                'comment' => 'A lot of comment about logo',
            ],
        ]);
        $this->assertResponseIsSuccessful();
    }
}
