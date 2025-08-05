<?php

namespace App\Services\LogoVersion;

use App\DTO\Branding\LogoVersionDTO;
use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\LogoVersion;
use App\Repository\Branding\LogoVersionRepository;
use App\Services\AbstractService;

final class LogoVersionService extends AbstractService implements LogoVersionServiceInterface
{
    public function __construct(
        private readonly LogoVersionRepository $logoVersionRepository,
    ) {
    }

    public function getLogoByBrandingId(BrandingProject $brandingProject): array
    {
        return $this->logoVersionRepository->findBy([
            'branding' => $brandingProject,
        ]);
    }

    public function convertToDTO(LogoVersion $logoVersion): LogoVersionDTO
    {
        return (new LogoVersionDTO())
            ->setId((int) $logoVersion->getId())
            ->setAssertUrl((string) $logoVersion->getAssetUrl())
            ->setApprovedAt($logoVersion->getApprovedAt() ?? new \DateTimeImmutable())
            ->setCreatedAt($logoVersion->getCreatedAt() ?? new \DateTimeImmutable())
        ;
    }

    public function convertAllToDTO(array $logoVersions): array
    {
        return array_map(
            fn ($logoVersion): LogoVersionDTO => $this->convertToDto($logoVersion),
            $logoVersions
        );
    }
}
