<?php

namespace App\Entity\Branding;

use App\Repository\Branding\DesignBriefRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DesignBriefRepository::class)]
class DesignBrief
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?array $colorPreferences = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'designBriefs', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?BrandingProject $branding = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getColorPreferences(): ?array
    {
        return $this->colorPreferences;
    }

    public function setColorPreferences(?array $colorPreferences): static
    {
        $this->colorPreferences = $colorPreferences;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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
