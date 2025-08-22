<?php

namespace App\Services\LogoGeneration;

use App\Entity\Branding\LogoVersion;
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

    /**
     * Publish logo to the frontend using MERCURE Bundle.
     */
    public function publishLogo(LogoVersion $logo, int $brandingId): void;
}
