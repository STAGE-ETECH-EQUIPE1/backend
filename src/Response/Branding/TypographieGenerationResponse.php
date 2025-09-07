<?php

namespace App\Response\Branding;

class TypographieGenerationResponse
{
    private string $fontType;

    /**
     * @var FontItemResponse
     */
    private array $fontList;

    public function __construct(
        string $fontType,
        array $fontList,
    ) {
        $this->fontType = $fontType;
        $this->fontList = $fontList;
    }

    /**
     * Get the value of fontList.
     */
    public function getFontList(): FontItemResponse
    {
        return $this->fontList;
    }

    /**
     * Get the value of fontType.
     */
    public function getFontType(): string
    {
        return $this->fontType;
    }
}
