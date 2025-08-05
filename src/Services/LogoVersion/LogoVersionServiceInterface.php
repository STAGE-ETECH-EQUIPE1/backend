<?php

namespace App\Services\LogoVersion;

use App\DTO\Branding\LogoVersionDTO;
use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\LogoVersion;

interface LogoVersionServiceInterface
{
    /**
     * Get All Logo Version from Branding Project.
     *
     * @return LogoVersion[]
     */
    public function getLogoByBrandingId(BrandingProject $brandingProject): array;

    /**
     * Convert LogoVersion To DTO.
     */
    public function convertToDTO(LogoVersion $logoVersion): LogoVersionDTO;

    /**
     * Convert All Logo Version to DTO.
     *
     * @param LogoVersion[] $logoVersions
     *
     * @return LogoVersionDTO[]
     */
    public function convertAllToDTO(array $logoVersions): array;
}
