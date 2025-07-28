<?php

namespace App\DTO\Branding;

use Symfony\Component\Validator\Constraints as Assert;

class DesignBriefDTO
{
    #[Assert\NotBlank()]
    private string $companyName = '';

    #[Assert\Length(min: 2, max: 250)]
    private string $description = '';

    #[Assert\NotNull]
    #[Assert\Count(min: 1)]
    private array $colorPreferences = [];

    #[Assert\Count(min: 1)]
    private array $brandKeywords = [];

    #[Assert\Url(requireTld: false)]
    private string $moodBoardUrl = '';

    /**
     * Get the value of brandKeywords.
     */
    public function getBrandKeywords(): array
    {
        return $this->brandKeywords;
    }

    /**
     * Set the value of brandKeywords.
     */
    public function setBrandKeywords(array $brandKeywords): static
    {
        $this->brandKeywords = $brandKeywords;

        return $this;
    }

    /**
     * Get the value of moodBoardUrl.
     */
    public function getMoodBoardUrl(): string
    {
        return $this->moodBoardUrl;
    }

    /**
     * Set the value of moodBoardUrl.
     */
    public function setMoodBoardUrl(string $moodBoardUrl): static
    {
        $this->moodBoardUrl = $moodBoardUrl;

        return $this;
    }

    /**
     * Get the value of description.
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description.
     */
    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of colorPreferences.
     */
    public function getColorPreferences(): array
    {
        return $this->colorPreferences;
    }

    /**
     * Set the value of colorPreferences.
     */
    public function setColorPreferences(array $colorPreferences): static
    {
        $this->colorPreferences = $colorPreferences;

        return $this;
    }

    /**
     * Get the value of companyName.
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * Set the value of companyName.
     */
    public function setCompanyName(string $companyName): static
    {
        $this->companyName = $companyName;

        return $this;
    }
}
