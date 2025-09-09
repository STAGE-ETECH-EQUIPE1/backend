<?php

namespace App\Tests\Controller\Subscription;

use ApiPlatform\Symfony\Bundle\Test\Response;
use App\Tests\Controller\ApiControllerTestCase;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ReadPackControllerTest extends ApiControllerTestCase
{
    use Factories;
    use ResetDatabase;

    public function testReadPack(): void
    {
        $token = $this->authenticateAdmin()->toArray()['token'];

        $client = static::createClient();

        $client->request(
            'GET',
            '/api/pack/show',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $token",
                ],
            ]
        );

        /** @var Response $response */
        $response = $client->getResponse();

        $this->assertResponseIsSuccessful();
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertIsArray($data);

        foreach ($data as $pack) {
            $this->assertIsArray($pack);

            $this->assertArrayHasKey('id', $pack);
            $this->assertIsInt($pack['id']);

            $this->assertArrayHasKey('name', $pack);
            $this->assertIsString($pack['name']);

            $this->assertArrayHasKey('price', $pack);
            $this->assertIsString($pack['price']);
            $this->assertMatchesRegularExpression('/^\d+(\.\d{1,2})?$/', $pack['price']);

            $this->assertArrayHasKey('services', $pack);
            $this->assertIsArray($pack['services']);

            foreach ($pack['services'] as $service) {
                $this->assertIsArray($service);

                $this->assertArrayHasKey('id', $service);
                $this->assertIsInt($service['id']);

                $this->assertArrayHasKey('name', $service);
                $this->assertIsString($service['name']);
            }
        }
    }
}
