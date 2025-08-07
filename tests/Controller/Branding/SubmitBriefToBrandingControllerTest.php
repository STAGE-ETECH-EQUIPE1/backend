<?php

namespace App\Tests\Controller\Branding;

use App\Entity\Branding\BrandingProject;
use App\Factory\Branding\BrandingProjectFactory;
use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class SubmitBriefToBrandingControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;
    use Factories;

    public function testSubmitValidBrief(): void
    {
        $token = $this->authenticateClient()->toArray()['token'];

        /** @var BrandingProject $branding */
        $branding = BrandingProjectFactory::createOne();
        $brandingId = (int) $branding->getId();

        $this->apiClient()->request('POST', "/api/branding-project/{$brandingId}/brief", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => "Bearer $token",
            ],
            'json' => [
                'description' => $this->getFaker()->sentence(),
                'slogan' => $this->getFaker()->sentence(2),
                'logoStyle' => 'modern',
                'colorPreferences' => [
                    $this->getFaker()->hexColor(),
                    $this->getFaker()->hexColor(),
                    $this->getFaker()->hexColor(),
                ],
                'brandKeywords' => [
                    $this->getFaker()->word(),
                    $this->getFaker()->word(),
                    $this->getFaker()->word(),
                ],
                'moodBoardUrl' => $this->getFaker()->imageUrl(),
            ],
        ]);

        $this->assertResponseIsSuccessful();
    }
}
