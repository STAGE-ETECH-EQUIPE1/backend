<?php

namespace App\Response\Branding;

class ColorPaletteGenerationResponse
{
    public function __construct(
        private string $name,
        private array $colors,
    ) {
    }

    /**
     * Get the value of colors.
     */
    public function getColors(): array
    {
        return $this->colors;
    }

    /**
     * Get the value of name.
     */
    public function getName(): string
    {
        return $this->name;
    }
}
