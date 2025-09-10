<?php

namespace App\Entity\Auth;

use App\Repository\Auth\UserTokensRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserTokensRepository::class)]
class UserTokens
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $companyNameTokens = null;

    #[ORM\Column]
    private ?int $colorPaletteTokens = null;

    #[ORM\Column]
    private ?int $typographyTokens = null;

    #[ORM\Column]
    private ?int $tonVoiceTokens = null;

    #[ORM\Column]
    private ?int $ValuesTokens = null;

    #[ORM\Column]
    private ?int $sloganTokens = null;

    #[ORM\Column]
    private ?int $logoGenerationTokens = null;

    #[ORM\OneToOne(inversedBy: 'userTokens', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $userInfo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyNameTokens(): int
    {
        return $this->companyNameTokens ?? 10;
    }

    public function setCompanyNameTokens(int $companyNameTokens): static
    {
        $this->companyNameTokens = $companyNameTokens;

        return $this;
    }

    public function decrementCompanyNameTokens(): static
    {
        if ($this->companyNameTokens > 0) {
            --$this->companyNameTokens;
        }

        return $this;
    }

    public function getColorPaletteTokens(): int
    {
        return $this->colorPaletteTokens ?? 10;
    }

    public function setColorPaletteTokens(int $colorPaletteTokens): static
    {
        $this->colorPaletteTokens = $colorPaletteTokens;

        return $this;
    }

    public function decrementColorPaletteTokens(): static
    {
        if ($this->colorPaletteTokens > 0) {
            --$this->colorPaletteTokens;
        }

        return $this;
    }

    public function getTypographyTokens(): int
    {
        return $this->typographyTokens ?? 10;
    }

    public function setTypographyTokens(int $typographyTokens): static
    {
        $this->typographyTokens = $typographyTokens;

        return $this;
    }

    public function decrementTypographyTokens(): static
    {
        if ($this->typographyTokens > 0) {
            --$this->typographyTokens;
        }

        return $this;
    }

    public function getTonVoiceTokens(): int
    {
        return $this->tonVoiceTokens ?? 10;
    }

    public function setTonVoiceTokens(int $tonVoiceTokens): static
    {
        $this->tonVoiceTokens = $tonVoiceTokens;

        return $this;
    }

    public function decrementTonVoiceTokens(): static
    {
        if ($this->tonVoiceTokens > 0) {
            --$this->tonVoiceTokens;
        }

        return $this;
    }

    public function getValuesTokens(): int
    {
        return $this->ValuesTokens ?? 10;
    }

    public function setValuesTokens(int $ValuesTokens): static
    {
        $this->ValuesTokens = $ValuesTokens;

        return $this;
    }

    public function decrementValuesTokens(): static
    {
        if ($this->ValuesTokens > 0) {
            --$this->ValuesTokens;
        }

        return $this;
    }

    public function getSloganTokens(): int
    {
        return $this->sloganTokens ?? 10;
    }

    public function setSloganTokens(int $sloganTokens): static
    {
        $this->sloganTokens = $sloganTokens;

        return $this;
    }

    public function decrementSloganTokens(): static
    {
        if ($this->sloganTokens > 0) {
            --$this->sloganTokens;
        }

        return $this;
    }

    public function getLogoGenerationTokens(): int
    {
        return $this->logoGenerationTokens ?? 10;
    }

    public function setLogoGenerationTokens(int $logoGenerationTokens): static
    {
        $this->logoGenerationTokens = $logoGenerationTokens;

        return $this;
    }

    public function decrementLogoGenerationTokens(): static
    {
        if ($this->logoGenerationTokens > 0) {
            --$this->logoGenerationTokens;
        }

        return $this;
    }

    public function getUserInfo(): ?Client
    {
        return $this->userInfo;
    }

    public function setUserInfo(Client $userInfo): static
    {
        $this->userInfo = $userInfo;

        return $this;
    }
}
