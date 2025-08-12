<?php

namespace App\Response\Logo;

use App\Entity\Branding\LogoVersion;

final class LogoPublishResponse
{
    private int $id;

    private string $assetUrl;

    private \DateTimeImmutable $createdAt;

    private \DateTimeImmutable $approvedAt;

    public function __construct(
        LogoVersion $logoVersion,
    ) {
        $this->id = (int) $logoVersion->getId();
        $this->assetUrl = (string) $logoVersion->getAssetUrl();
        $this->createdAt = $logoVersion->getCreatedAt() ?? new \DateTimeImmutable();
        $this->approvedAt = $logoVersion->getApprovedAt() ?? new \DateTimeImmutable();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAssetUrl(): string
    {
        return $this->assetUrl;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getApprovedAt(): \DateTimeImmutable
    {
        return $this->approvedAt;
    }


}
