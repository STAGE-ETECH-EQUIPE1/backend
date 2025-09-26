<?php

namespace App\Request\Branding;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class DesignBriefRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Length(
        min: 2,
        max: 200,
        minMessage: 'MIN_LENGTH_VALIDATION',
        maxMessage: 'MAX_LENGTH_VALIDATION'
    )]
    private string $logoStyle = '';

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Length(
        min: 2,
        max: 250,
        minMessage: 'MIN_LENGTH_VALIDATION',
        maxMessage: 'MAX_LENGTH_VALIDATION'
    )]
    private string $description = '';

    #[Assert\NotNull(message: 'NOT_NULL_VALIDATION')]
    #[Assert\Count(min: 1, minMessage: 'MIN_COUNT_VALIDATION')]
    private array $colorPreferences = [];

    #[Assert\Url(requireTld: false, message: 'NOT_VALID_URL_VALIDATION')]
    private string $moodBoardUrl = '';

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->logoStyle = $content['logoStyle'] ?? '';
        $this->description = $content['description'] ?? '';
        $this->colorPreferences = $content['colorPreferences'] ?? [];
        $this->moodBoardUrl = $content['moodBoardUrl'] ?? '';
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
}
