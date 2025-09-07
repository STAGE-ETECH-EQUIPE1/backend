<?php

namespace App\Request\Branding;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ColorPaletteGenerationRequest
{
    #[Assert\Count(
        min: 1, minMessage: 'MIN_COUNT_VALIDATION',
        max: 5, maxMessage: 'MAX_COUNT_VALIDATION'
    )]
    private array $colorFavorites;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    private string $styleSearch;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    private string $emotion;

    #[Assert\PositiveOrZero(message: 'POSITIVE_OR_ZERO_VALIDATION')]
    #[Assert\LessThanOrEqual(value: 6, message: 'LESS_THEN_VALIDATION')]
    private int $colorNumber;

    #[Assert\Count(
        max: 5, maxMessage: 'MAX_COUNT_VALIDATION'
    )]
    private array $colorExcepts;

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->colorFavorites = $content['colorFavorites'];
        $this->styleSearch = $content['styleSearch'];
        $this->emotion = $content['emotion'];
        $this->colorNumber = $content['colorNumber'];
        $this->colorExcepts = $content['colorExcepts'];
    }

    /**
     * Get the value of colorExcepts.
     */
    public function getColorExcepts(): array
    {
        return $this->colorExcepts;
    }

    /**
     * Get the value of colorNumber.
     */
    public function getColorNumber(): int
    {
        return $this->colorNumber;
    }

    /**
     * Get the value of emotion.
     */
    public function getEmotion(): string
    {
        return $this->emotion;
    }

    /**
     * Get the value of styleSearch.
     */
    public function getStyleSearch(): string
    {
        return $this->styleSearch;
    }

    /**
     * Get the value of colorFavorites.
     */
    public function getColorFavorites(): array
    {
        return $this->colorFavorites;
    }
}
