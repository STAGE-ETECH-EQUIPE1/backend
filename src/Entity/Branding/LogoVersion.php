<?php

namespace App\Entity\Branding;

use App\Repository\Branding\LogoVersionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogoVersionRepository::class)]
class LogoVersion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $assetUrl = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $approvedAt = null;

    #[ORM\Column]
    private ?int $iterationNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssetUrl(): ?string
    {
        return $this->assetUrl;
    }

    public function setAssetUrl(string $assetUrl): static
    {
        $this->assetUrl = $assetUrl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getApprovedAt(): ?\DateTimeImmutable
    {
        return $this->approvedAt;
    }

    public function setApprovedAt(?\DateTimeImmutable $approvedAt): static
    {
        $this->approvedAt = $approvedAt;

        return $this;
    }

    public function getIterationNumber(): ?int
    {
        return $this->iterationNumber;
    }

    public function setIterationNumber(int $iterationNumber): static
    {
        $this->iterationNumber = $iterationNumber;

        return $this;
    }
}
