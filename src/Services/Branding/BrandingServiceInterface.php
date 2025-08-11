<?php

namespace App\Services\Branding;

use App\DTO\Branding\BrandingProjectDTO;
use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\DesignBrief;
use App\Request\Branding\DesignBriefRequest;

interface BrandingServiceInterface
{
    /**
     * Get All Branding Project.
     *
     * @return BrandingProject[]
     */
    public function getAllBrandingProject(): array;

    /**
     * Create new branding project based on the provided message.
     */
    public function createNewBrandingProject(DesignBriefRequest $designBriefDTO): DesignBrief;

    /**
     * Submit Design brief to branding project for generating a new logo with the brief submitted.
     */
    public function submitDesignBriefByBrandingProjectId(BrandingProject $brandingProject, DesignBriefRequest $designBriefDTO): DesignBrief;

    /**
     * Convert BrandingProject to DTO for serialization.
     */
    public function convertToDTO(BrandingProject $brandingProject): BrandingProjectDTO;

    /**
     * Convert all Branding Project to DTO.
     *
     * @param BrandingProject[] $brandingProjects
     *
     * @return BrandingProjectDTO[]
     */
    public function convertAllToDTO(array $brandingProjects): array;
}
