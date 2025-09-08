<?php

namespace App\Factory\Branding;

use App\Entity\Branding\BrandingProject;
use App\Enum\BrandingStatus;
use App\Factory\Auth\ClientFactory;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<BrandingProject>
 */
final class BrandingProjectFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return BrandingProject::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array
    {
        $date = \DateTimeImmutable::createFromMutable(self::faker()->dateTimeThisYear('+3 months'));

        return [
            'client' => ClientFactory::new(),
            'description' => self::faker()->sentence(),
            'createdAt' => $date,
            'deadLine' => $date->modify('+1 month'),
            'status' => self::faker()->randomElement(BrandingStatus::cases()),
            'logos' => LogoVersionFactory::createMany(5),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(BrandingProject $brandingProject): void {})
        ;
    }
}
