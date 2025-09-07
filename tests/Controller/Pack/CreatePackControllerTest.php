<?php

namespace App\Tests\Controller\Pack;

use App\Entity\Subscription\Service;
use App\Tests\Controller\ApiControllerTestCase;
use Doctrine\ORM\EntityManagerInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreatePackControllerTest extends ApiControllerTestCase
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

    public function testCreatePack(): void
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

        $this->assertResponseStatusCodeSame(201);
    }
}
