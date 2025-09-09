<?php

namespace App\Request\BrandingVerbal;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CompanySloganRequest
{
    #[Assert\Type('string')]
    private ?string $tone = null;

    #[Assert\Choice(['court', 'moyen', 'long'])]
    private ?string $length = null;

    #[Assert\Type('string')]
    private ?string $langue = null;

    #[Assert\Type('array')]
    #[Assert\All([new Assert\Type('string')])]
    private ?array $include_keywords = null;

    #[Assert\Type('array')]
    #[Assert\All([new Assert\Type('string')])]
    private ?array $exclude_keywords = null;

    #[Assert\Type('string')]
    private ?string $focus = null;

    public function __construct(Request $request)
    {
        $content = $request->toArray();

        $this->tone = $content['tone'] ?? null;
        $this->length = $content['length'] ?? null;
        $this->langue = $content['langue'] ?? null;
        $this->include_keywords = $content['include_keywords'] ?? null;
        $this->exclude_keywords = $content['exclude_keywords'] ?? null;
        $this->focus = $content['focus'] ?? null;
    }

    public function getTone(): ?string
    {
        return $this->tone;
    }

    public function getLength(): ?string
    {
        return $this->length;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function getIncludeKeywords(): ?array
    {
        return $this->include_keywords;
    }

    public function getExcludeKeywords(): ?array
    {
        return $this->exclude_keywords;
    }

    public function getFocus(): ?string
    {
        return $this->focus;
    }
}
