<?php

namespace App\Services\Branding;

use App\Message\Branding\GenerateLogoMessage;

interface BrandingServiceInterface
{
    /**
     * Generate logo from Google Gemini API using the provided design brief.
     */
    public function generateLogoFromGoogleAiStudio(GenerateLogoMessage $message): void;
}
