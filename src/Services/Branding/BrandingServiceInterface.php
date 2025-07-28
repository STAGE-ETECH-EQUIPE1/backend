<?php

namespace App\Services\Branding;

use App\DTO\Branding\DesignBriefDTO;
use App\Entity\Branding\DesignBrief;
use App\Message\Branding\GenerateLogoMessage;

interface BrandingServiceInterface
{
    /**
     * Generate logo from Google Gemini API using the provided design brief.
     */
    public function generateLogoFromGoogleAiStudio(GenerateLogoMessage $message): void;

    /**
     * Create new branding project based on the provided message.
     */
    public function createNewBrandingProject(DesignBriefDTO $designBriefDTO): DesignBrief;

    public function buildPromptText(DesignBriefDTO $designBrief): string;
}
