<?php

namespace App\Tests\Controller\Branding;

use App\Entity\Branding\BrandingProject;
use App\Factory\Branding\BrandingProjectFactory;
use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetLogoFromBrandingControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;
    use Factories;

    public function testGetLogoForBrandingProject(): void
    {
        /** @var BrandingProject $branding */
        $branding = BrandingProjectFactory::createOne();
        $brandingId = (int) $branding->getId();

        $response = $this->apiClient()->request('GET', "/api/branding-project/$brandingId/logos", [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $content = $response->toArray();
        $this->assertArrayHasKey('data', $content);

        $this->assertCount(5, $content['data']);
    }
}
