<?php

namespace App\Tests\Controller\Subscription;

use ApiPlatform\Symfony\Bundle\Test\Response;
use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ServiceControllerTest extends ApiControllerTestCase
{
    use Factories;
    use ResetDatabase;

    public function testCreateService(): void
    {
        $token = $this->authenticateAdmin()->toArray()['token'];

        $this->apiClient()->request('POST', '/api/service/create', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer $token",
            ], 'json' => [
                'name' => 'testName',
                'price' => '25.2',
            ]]);
        $this->assertResponseStatusCodeSame(201);
    }

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

    public function testUpdateService(): void
    {
        $token = $this->authenticateAdmin()->toArray()['token'];

        $client = $this->apiClient();

        $client->request('POST', '/api/service/create', ['headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $token",
        ], 'json' => [
            'name' => 'testName',
            'price' => '25.2',
        ]]);

        $this->assertResponseIsSuccessful();

        /** @var Response $response */
        $response = $client->getResponse();

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $id = $data['id'];

        $client->request('PUT', "/api/service/edit/$id", ['headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $token",
        ], 'json' => [
            'name' => 'newName',
            'price' => '258.25',
        ]]);

        $this->assertResponseIsSuccessful();

        /** @var Response $response */
        $response = $client->getResponse();

        $this->assertJson($response->getContent());

        $services = $response->toArray();

        $this->assertEquals($id, $services['service']['id']);
        $this->assertEquals('newName', $services['service']['name']);
        $this->assertEquals('258.25', $services['service']['price']);
    }
}
