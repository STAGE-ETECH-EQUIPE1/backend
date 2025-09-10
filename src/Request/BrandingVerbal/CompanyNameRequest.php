<?php

namespace App\Request\BrandingVerbal;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CompanyNameRequest
{
    #[Assert\Type('array')]
    #[Assert\All([
        new Assert\Type('string'),
    ])]
    private ?array $include_keywords = null;

    #[Assert\Type('array')]
    #[Assert\All([
        new Assert\Type('string'),
    ])]
    private ?array $exclude_keywords = null;

    #[Assert\Type('string')]
    private ?string $length = null;

    #[Assert\Type('string')]
    private ?string $style = null;

    #[Assert\Type('string')]
    private ?string $langue = null;

    #[Assert\Type('bool')]
    private ?bool $check_social_media = null;

    public function __construct(Request $request)
    {
        $content = $request->toArray();

        $this->include_keywords = $content['include_keywords'] ?? null;
        $this->exclude_keywords = $content['exclude_keywords'] ?? null;
        $this->length = $content['length'] ?? null;
        $this->style = $content['style'] ?? null;
        $this->langue = $content['langue'] ?? null;
        $this->check_social_media = $content['check_social_media'] ?? null;
    }

    public function getIncludeKeywords(): ?array
    {
        return $this->include_keywords;
    }

    public function setIncludeKeywords(?array $include_keywords): void
    {
        $this->include_keywords = $include_keywords;
    }

    public function getExcludeKeywords(): ?array
    {
        return $this->exclude_keywords;
    }

    public function setExcludeKeywords(?array $exclude_keywords): void
    {
        $this->exclude_keywords = $exclude_keywords;
    }

    public function getLength(): ?string
    {
        return $this->length;
    }

    public function setLength(?string $length): void
    {
        $this->length = $length;
    }

    public function getStyle(): ?string
    {
        return $this->style;
    }

    public function setStyle(?string $style): void
    {
        $this->style = $style;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): void
    {
        $this->langue = $langue;
    }

    public function isCheckSocialMedia(): ?bool
    {
        return $this->check_social_media;
    }

    public function setCheckSocialMedia(?bool $check_social_media): void
    {
        $this->check_social_media = $check_social_media;
    }
}
