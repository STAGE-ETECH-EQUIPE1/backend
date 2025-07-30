<?php

namespace App\Entity\Branding;

use App\Repository\Branding\DesignBriefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'designBriefs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BrandingProject $branding = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $moodBoardUrl = null;

    #[ORM\Column(length: 200)]
    private ?string $logoStyle = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $slogan = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $brandKeywords = [];

    /**
     * @var Collection<int, LogoVersion>
     */
    #[ORM\OneToMany(targetEntity: LogoVersion::class, mappedBy: 'brief')]
    private Collection $logos;

    public function __construct()
    {
        $this->logos = new ArrayCollection();
    }

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

    public function getMoodBoardUrl(): ?string
    {
        return $this->moodBoardUrl;
    }

    public function setMoodBoardUrl(?string $moodBoardUrl): static
    {
        $this->moodBoardUrl = $moodBoardUrl;

        return $this;
    }

    public function getLogoStyle(): ?string
    {
        return $this->logoStyle;
    }

    public function setLogoStyle(string $logoStyle): static
    {
        $this->logoStyle = $logoStyle;

        return $this;
    }

    public function getSlogan(): ?string
    {
        return $this->slogan;
    }

    public function setSlogan(?string $slogan): static
    {
        $this->slogan = $slogan;

        return $this;
    }

    public function getBrandKeywords(): array
    {
        return $this->brandKeywords;
    }

    public function setBrandKeywords(array $brandKeywords): static
    {
        $this->brandKeywords = $brandKeywords;

        return $this;
    }

    /**
     * @return Collection<int, LogoVersion>
     */
    public function getLogos(): Collection
    {
        return $this->logos;
    }

    public function addLogo(LogoVersion $logo): static
    {
        if (!$this->logos->contains($logo)) {
            $this->logos->add($logo);
            $logo->setBrief($this);
        }

        return $this;
    }

    public function removeLogo(LogoVersion $logo): static
    {
        if ($this->logos->removeElement($logo)) {
            // set the owning side to null (unless already changed)
            if ($logo->getBrief() === $this) {
                $logo->setBrief(null);
            }
        }

        return $this;
    }
}
