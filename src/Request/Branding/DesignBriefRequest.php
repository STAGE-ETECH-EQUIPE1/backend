<?php

namespace App\Request\Branding;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class DesignBriefRequest
{
    #[Assert\Length(min: 2, max: 200)]
    private string $slogan = '';

    #[Assert\Length(min: 2, max: 200)]
    private string $logoStyle = '';

    #[Assert\Length(min: 2, max: 250)]
    private string $description = '';

    #[Assert\NotNull]
    #[Assert\Count(min: 1)]
    private array $colorPreferences = [];

    #[Assert\Count(min: 1)]
    private array $brandKeywords = [];

    #[Assert\Url(requireTld: false)]
    private string $moodBoardUrl = '';

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->slogan = $content['slogan'];
        $this->logoStyle = $content['logoStyle'];
        $this->description = $content['description'];
        $this->colorPreferences = $content['colorPreferences'];
        $this->brandKeywords = $content['brandKeywords'];
        $this->moodBoardUrl = $content['moodBoardUrl'];
    }

    /**
     * Get the value of brandKeywords.
     */
    public function getBrandKeywords(): array
    {
        return $this->brandKeywords;
    }

    /**
     * Get the value of moodBoardUrl.
     */
    public function getMoodBoardUrl(): string
    {
        return $this->moodBoardUrl;
    }

    /**
     * Get the value of description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Get the value of colorPreferences.
     */
    public function getColorPreferences(): array
    {
        return $this->colorPreferences;
    }

    public function getLogoStyle(): string
    {
        return $this->logoStyle;
    }

    public function getSlogan(): string
    {
        return $this->slogan;
    }
}
