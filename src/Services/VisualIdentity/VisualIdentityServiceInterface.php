<?php

namespace App\Services\VisualIdentity;

use App\Request\Branding\ColorPaletteGenerationRequest;
use App\Request\Branding\TypographieGenerationRequest;

interface VisualIdentityServiceInterface
{
    /**
     * Generate Color Palettes from AI.
     */
    public function generateColorPalettes(ColorPaletteGenerationRequest $request): array;

    /**
     * Generate Typographies from AI.
     */
    public function generateTypographies(TypographieGenerationRequest $request): array;
}
