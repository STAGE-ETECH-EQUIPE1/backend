<?php

namespace App\Request\CompanyValues;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class CompanyValuesRequest
{
    #[Assert\Type('string')]
    private ?string $mission = null;

    #[Assert\Type('string')]
    private ?string $vision = null;

    #[Assert\Type('array')]
    #[Assert\All([new Assert\Type('string')])]
    private ?array $values = null;

    #[Assert\Choice(['premium', 'accessible', 'fun', 'sérieux', 'innovant'])]
    private ?string $positioning = null;

    #[Assert\Type('array')]
    #[Assert\All([new Assert\Type('string')])]
    private ?array $avoid_examples = null;

    #[Assert\Choice(['local', 'national', 'international'])]
    private ?string $market_scope = null;

    public function __construct(Request $request)
    {
        $content = $request->toArray();

        $this->mission        = $content['mission'] ?? null;
        $this->vision         = $content['vision'] ?? null;
        $this->values         = $content['values'] ?? null;
        $this->positioning    = $content['positioning'] ?? null;
        $this->avoid_examples = $content['avoid_examples'] ?? null;
        $this->market_scope   = $content['market_scope'] ?? null;
    }

    public function getMission(): ?string
    {
        return $this->mission;
    }

    public function getVision(): ?string
    {
        return $this->vision;
    }

    public function getValues(): ?array
    {
        return $this->values;
    }

    public function getPositioning(): ?string
    {
        return $this->positioning;
    }

    public function getAvoidExamples(): ?array
    {
        return $this->avoid_examples;
    }

    public function getMarketScope(): ?string
    {
        return $this->market_scope;
    }
}
