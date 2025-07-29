<?php

namespace App\Services\LogoGeneration;

use App\Message\Branding\GenerateLogoMessage;

interface LogoGenerationServiceInterface
{
    /**
     * Generate logo from Google Gemini API using the provided design brief.
     */
    public function generateLogoFromGoogleAiStudio(GenerateLogoMessage $message): void;
}
