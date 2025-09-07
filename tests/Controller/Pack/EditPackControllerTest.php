<?php

namespace App\Tests\Controller\Pack;

use ApiPlatform\Symfony\Bundle\Test\Response;
use App\Entity\Subscription\Service;
use App\Tests\Controller\ApiControllerTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class EditPackControllerTest extends ApiControllerTestCase
{
    use Factories;
    use ResetDatabase;

    private function createService(string $name = 'testeService', string $price = '2.25'): Service
    {
        $container = static::getContainer();

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $container->get(EntityManagerInterface::class);

        $service = new Service();
        $service->setName($name);
        $service->setPrice($price);

        $entityManager->persist($service);
        $entityManager->flush();

        return $service;
    }

    public function testUpdatePack(): void
    {
        $token = $this->authenticateAdmin()->toArray()['token'];

        $client = $this->apiClient();

        $service = $this->createService();

        $client->request(
            'POST',
            '/api/pack/create',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer $token",
                ],
                'json' => [
                    'name' => 'PackTest',
                    'price' => '100.36',
                    'startedAt' => '2025-08-04',
                    'expiredAt' => '2025-09-04',
                    'services' => [$service->getId()],
                ],
            ]);

        $this->assertResponseIsSuccessful();

        /** @var Response $response */
        $response = $client->getResponse();

        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $id = $data['id'];

        $service2 = $this->createService('rakoto', '258');

        $client->request('PUT', "/api/pack/edit/$id", ['headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $token",
        ], 'json' => [
            'name' => 'NewPackTest',
            'price' => '100.36',
            'startedAt' => '2025-08-04',
            'expiredAt' => '2025-09-05',
            'services' => [$service2->getId()],
        ]]);

        $this->assertResponseIsSuccessful();

        /** @var Response $response */
        $response = $client->getResponse();

        $this->assertJson($response->getContent());

        $pack = $response->toArray();

        $this->assertEquals($id, $pack['pack']['id']);
        $this->assertEquals('NewPackTest', $pack['pack']['name']);

        $this->assertIsArray($pack['pack']['services']);
        $serviceIds = array_map(fn ($service) => $service['id'], $pack['pack']['services']);
        $this->assertContains($service2->getId(), $serviceIds);
    }
}
