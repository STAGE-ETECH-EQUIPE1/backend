<?php

namespace App\Response\Subscription;

use App\Entity\Auth\UserTokens;

class TokensResponse
{
    private int $companyNameTokens;

    private int $colorPaletteTokens;

    private int $typographyTokens;

    private int $tonVoiceTokens;

    private int $valuesTokens;

    private int $sloganTokens;

    private int $logoGenerationTokens;

    public function __construct(UserTokens $userTokens)
    {
        $this->companyNameTokens = $userTokens->getCompanyNameTokens();
        $this->colorPaletteTokens = $userTokens->getColorPaletteTokens();
        $this->typographyTokens = $userTokens->getTypographyTokens();
        $this->tonVoiceTokens = $userTokens->getTonVoiceTokens();
        $this->valuesTokens = $userTokens->getValuesTokens();
        $this->sloganTokens = $userTokens->getSloganTokens();
        $this->logoGenerationTokens = $userTokens->getLogoGenerationTokens();
    }

    /**
     * Get the value of logoGenerationTokens.
     */
    public function getLogoGenerationTokens(): int
    {
        return $this->logoGenerationTokens;
    }

    /**
     * Get the value of sloganTokens.
     */
    public function getSloganTokens(): int
    {
        return $this->sloganTokens;
    }

    /**
     * Get the value of valuesTokens.
     */
    public function getValuesTokens(): int
    {
        return $this->valuesTokens;
    }

    /**
     * Get the value of tonVoiceTokens.
     */
    public function getTonVoiceTokens(): int
    {
        return $this->tonVoiceTokens;
    }

    /**
     * Get the value of typographyTokens.
     */
    public function getTypographyTokens(): int
    {
        return $this->typographyTokens;
    }

    /**
     * Get the value of ColorPaletteTokens.
     */
    public function getColorPaletteTokens(): int
    {
        return $this->colorPaletteTokens;
    }

    /**
     * Get the value of companyNameTokens.
     */
    public function getCompanyNameTokens(): int
    {
        return $this->companyNameTokens;
    }
}
