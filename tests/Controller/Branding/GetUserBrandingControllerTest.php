<?php

namespace App\Tests\Controller\Branding;

use App\Entity\Auth\Client;
use App\Factory\Branding\BrandingProjectFactory;
use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetUserBrandingControllerTest extends ApiControllerTestCase
{
    use Factories;
    use ResetDatabase;

    public function testGetAllClientBrandings(): void
    {
        /** @var Client $client */
        $client = $this->getClientUser()->getClient();

        $token = $this->authenticateClient()->toArray()['token'];

        BrandingProjectFactory::new([
            'client' => $client,
        ]);
        BrandingProjectFactory::new([
            'client' => $client,
        ]);
        BrandingProjectFactory::new([
            'client' => $client,
        ]);

        $response = $this->apiClient()->request('GET', '/api/branding-projects', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token",
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $content = $response->toArray();
    }
}
