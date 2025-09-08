<?php

namespace App\Tests\Controller\Service;

use ApiPlatform\Symfony\Bundle\Test\Response;
use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ReadServiceControllerTest extends ApiControllerTestCase
{
    use Factories;
    use ResetDatabase;

    public function testReadService(): void
    {
        $token = $this->authenticateAdmin()->toArray()['token'];

        $client = $this->apiClient();
        $client->request('GET', '/api/service/show', ['headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $token",
        ]]);

        /** @var Response $response */
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);

        foreach ($data as $item) {
            $this->assertArrayHasKey('id', $item);
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayHasKey('price', $item);

            $this->assertIsInt($item['id']);
            $this->assertIsString($item['name']);
            $this->assertMatchesRegularExpression('/^\d+(\.\d{1,2})?$/', $item['price']);
        }
    }
}
