<?php

namespace App\Services\LogoVersion;

use App\DTO\Branding\ClientFeedBackDTO;
use App\DTO\Branding\LogoVersionDTO;
use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\ClientFeedBack;
use App\Entity\Branding\LogoVersion;
use App\Request\Logo\CommentLogoRequest;

interface LogoVersionServiceInterface
{
    /**
     * Get All Logo Version from Branding Project.
     *
     * @return LogoVersion[]
     */
    public function getLogoByBrandingId(BrandingProject $brandingProject): array;

    /**
     * Get all clients feedback from a specific logo.
     *
     * @return ClientFeedBack[]
     */
    public function getLogoFeedBackByLogoId(int $id): array;

    /**
     * Create feedback from client request.
     */
    public function commentLogo(LogoVersion $logo, CommentLogoRequest $comment): void;

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

    /**
     * Convert Client Feed Back to DTO.
     */
    public function convertClientFeedBackToDTO(ClientFeedBack $clientFeedBack): ClientFeedBackDTO;

    /**
     * Convert All Clients FeedBacks to DTO.
     *
     * @param ClientFeedBack[] $clientFeedBacks
     *
     * @return ClientFeedBackDTO[]
     */
    public function convertAllClientFeedBacksToDTO(array $clientFeedBacks): array;
}
