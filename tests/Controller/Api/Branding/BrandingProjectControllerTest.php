<?php

namespace App\Tests\Controller\Api\Branding;

use App\Tests\Controller\Api\ApiControllerTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class BrandingProjectControllerTest extends ApiControllerTestCase
{
    use ResetDatabase;

    public function testValidSubmitBrief(): void
    {
        $token = $this->authenticateClient()->toArray()['token'];

        $this->apiClient()->request('POST', '/api/branding-project', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$token}",
            ],
            'json' => [
                'companyName' => 'Test Company Name',
                'description' => 'A lot of description about company',
                'colorPreferences' => [
                    'slogan' => '#5a172c',
                    'name' => '#320b7f',
                    'background' => '#0f411c',
                ],
                'brandKeywords' => [
                    'Recruitment', 'Consultation', 'Creativity',
                ],
                'moodBoardUrl' => 'https://example.com/mood-board',
            ],
        ]);
        $this->assertResponseIsSuccessful();
    }

    public function testUnauthorizedSubmitBrief(): void
    {
        $this->apiClient()->request('POST', '/api/branding-project', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'companyName' => 'Test Company Name',
                'description' => 'A lot of description about company',
                'colorPreferences' => [
                    'slogan' => '#5a172c',
                    'name' => '#320b7f',
                    'background' => '#0f411c',
                ],
                'brandKeywords' => [
                    'Recruitment', 'Consultation', 'Creativity',
                ],
                'moodBoardUrl' => 'https://example.com/mood-board',
            ],
        ]);
        $this->assertResponseStatusCodeSame(401);
    }
}
