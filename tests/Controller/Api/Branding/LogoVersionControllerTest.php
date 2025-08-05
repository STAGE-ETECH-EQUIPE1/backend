<?php

namespace App\Tests\Controller\Api\Branding;

use App\Entity\Branding\LogoVersion;
use App\Tests\Controller\Api\ApiControllerTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class LogoVersionControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;

    private function createEmptyLogoVersion(): void
    {
        $logoVersion = (new LogoVersion())
            ->setAssetUrl('public/generated-ai/logo/1/6891dd167e838.png')
            ->setCreatedAt(new \DateTimeImmutable())
            ->setApprovedAt(new \DateTimeImmutable())
        ;

        $this->saveEntity($logoVersion);
    }

    public function testValidCommentLogoById(): void
    {
        $this->createEmptyLogoVersion();

        $token = $this->authenticateClient()->toArray()['token'];

        $this->apiClient()->request('POST', '/api/logo/1/comment', [
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
