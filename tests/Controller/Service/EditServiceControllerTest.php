<?php

namespace App\Tests\Controller\Subscription;

use ApiPlatform\Symfony\Bundle\Test\Response;
use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class EditServiceControllerTest extends ApiControllerTestCase
{
    use Factories;
    use ResetDatabase;
    
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
