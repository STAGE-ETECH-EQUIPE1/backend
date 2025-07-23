<?php

namespace App\Entity\Branding;

use App\Repository\Branding\BrandAiPromptHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandAiPromptHistoryRepository::class)]
class BrandAiPromptHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $promptText = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $executedAt = null;

    #[ORM\ManyToOne(inversedBy: 'brandAiPromptHistories')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BrandingProject $branding = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPromptText(): ?string
    {
        return $this->promptText;
    }

    public function setPromptText(string $promptText): static
    {
        $this->promptText = $promptText;

        return $this;
    }

    public function getExecutedAt(): ?\DateTimeImmutable
    {
        return $this->executedAt;
    }

    public function setExecutedAt(\DateTimeImmutable $executedAt): static
    {
        $this->executedAt = $executedAt;

        return $this;
    }

    public function getBranding(): ?BrandingProject
    {
        return $this->branding;
    }

    public function setBranding(?BrandingProject $branding): static
    {
        $this->branding = $branding;

        return $this;
    }
}
