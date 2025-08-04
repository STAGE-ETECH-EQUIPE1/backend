<?php

namespace App\Tests\Controller\Api\Subscription;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Subscription\Service;
use Doctrine\ORM\EntityManagerInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class PackControllerTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testCreatePack(): void
    {
        $client = static::createClient();
        $container = static::getContainer();
        $entityManager = $container->get(EntityManagerInterface::class);

        $service = new Service();
        $service->setName('testService');
        $service->setPrice(30.0);
        $entityManager->persist($service);
        $entityManager->flush();

        $client->request('POST', '/api/pack/create', ['json' => [
            'name' => 'PackTest',
            'price' => '100.36',
            'startedAt' => '2025-08-04',
            'expiredAt' => '2025-09-04',
            'services' => [$service->getId()],
        ]]);

        $this->assertResponseStatusCodeSame(201);
    }

    
}
