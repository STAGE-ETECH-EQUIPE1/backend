<?php

namespace App\Response\Branding;

class FontItemResponse
{
    public function __construct(
        private string $fontName,
        private string $relevance,
        private string $impact,
    ) {
    }

    /**
     * Get the value of impact.
     */
    public function getImpact(): string
    {
        return $this->impact;
    }

    /**
     * Get the value of relevance.
     */
    public function getRelevance(): string
    {
        return $this->relevance;
    }

    /**
     * Get the value of fontName.
     */
    public function getFontName(): string
    {
        return $this->fontName;
    }
}
