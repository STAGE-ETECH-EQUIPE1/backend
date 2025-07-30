<?php

namespace App\Services\LogoGeneration;

use App\Message\Branding\GenerateLogoMessage;
use App\Message\Branding\RegenerateLogoMessage;

interface LogoGenerationServiceInterface
{
    /**
     * Generate logo from Google Gemini API using the provided design brief.
     */
    public function generateLogoFromGoogleAiStudio(GenerateLogoMessage $message): void;

    /**
     * Generate another logo from existing branding project.
     */
    public function generateNewLogoFromExistingBrandingProject(RegenerateLogoMessage $message): void;
}
