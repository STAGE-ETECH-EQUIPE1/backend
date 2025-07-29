<?php

namespace App\Services\Branding;

use App\DTO\Branding\DesignBriefDTO;
use App\Entity\Branding\DesignBrief;

interface BrandingServiceInterface
{
    /**
     * Create new branding project based on the provided message.
     */
    public function createNewBrandingProject(DesignBriefDTO $designBriefDTO): DesignBrief;

    public function buildPromptText(DesignBriefDTO $designBrief): string;
}
