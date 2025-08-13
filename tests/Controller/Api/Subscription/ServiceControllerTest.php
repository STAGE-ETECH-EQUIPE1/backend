<?php

namespace App\Tests\Controller\Api\Subscription;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ServiceControllerTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testCreateService(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/service/create', ['json' => [
            'name' => 'testName',
            'price' => '25.2',
        ]]);
        $this->assertResponseStatusCodeSame(201);
    }

    public function testReadService(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/service/show');

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
        $client = static::createClient();

        $client->request('POST', '/api/service/create', ['json' => [
            'name' => 'testName',
            'price' => '25.2',
        ]]);

        $this->assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $id = $data['id'];

        $client->request('PUT', "/api/service/edit/$id", ['json' => [
            'name' => 'newName',
            'price' => '258.25',
        ]]);

        $this->assertResponseIsSuccessful();
        $response = $client->getResponse();
        $this->assertJson($response->getContent());

        $services = $response->toArray();

        $this->assertEquals($id, $services['service']['id']);
        $this->assertEquals('newName', $services['service']['name']);
        $this->assertEquals('258.25', $services['service']['price']);
    }
}
