<?php

namespace App\Request\Branding;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class TypographieGenerationRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    private string $styleSearch;

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->styleSearch = $content['styleSearch'];
    }

    /**
     * Get the value of styleSearch.
     */
    public function getStyleSearch(): string
    {
        return $this->styleSearch;
    }
}
