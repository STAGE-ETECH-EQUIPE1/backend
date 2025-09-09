<?php

namespace App\Factory\Auth;

use App\Entity\Auth\Client;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Client>
 */
final class ClientFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Client::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array
    {
        $companyAreas = [
            'health', 'industry', 'sports', 'healthcare',
        ];
        $publicTargets = [
            'family', 'children', 'tourist',
        ];

        return [
            'companyName' => self::faker()->company(),
            'companyArea' => $companyAreas[array_rand($companyAreas)] ?? 'health',
            'slogan' => self::faker()->sentence(2),
            'tonVoice' => self::faker()->sentence(2),
            'qualities' => self::faker()->word(),
            'publicTarget' => $publicTargets[array_rand($publicTargets)] ?? 'tourist',
            'userInfo' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Client $client): void {})
        ;
    }
}
