<?php

namespace App\Factory\Branding;

use App\Entity\Branding\LogoVersion;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<LogoVersion>
 */
final class LogoVersionFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return LogoVersion::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array
    {
        return [
            'assetUrl' => self::faker()->text(200),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'iterationNumber' => self::faker()->randomNumber(),
            'brief' => DesignBriefFactory::createOne(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(LogoVersion $logoVersion): void {})
        ;
    }
}
