<?php

namespace App\Factory\Branding;

use App\Entity\Branding\DesignBrief;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<DesignBrief>
 */
final class DesignBriefFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return DesignBrief::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     */
    protected function defaults(): array
    {
        $logoStyle = [
            'modern', 'traditionnal', 'pictorial mark', 'abstract logo',
        ];

        return [
            'colorPreferences' => [
                self::faker()->hexColor(),
                self::faker()->hexColor(),
                self::faker()->hexColor(),
            ],
            'description' => self::faker()->sentence(),
            'brandKeywords' => [
                self::faker()->sentence(1),
                self::faker()->sentence(1),
                self::faker()->sentence(1),
            ],
            'slogan' => self::faker()->sentence(2),
            'logoStyle' => $logoStyle[array_rand($logoStyle)],
            'moodBoardUrl' => self::faker()->imageUrl(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(DesignBrief $designBrief): void {})
        ;
    }
}
