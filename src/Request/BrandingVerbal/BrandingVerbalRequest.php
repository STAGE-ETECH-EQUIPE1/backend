<?php

namespace App\Request\BrandingVerbal;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class BrandingVerbalRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type('string', message: 'NOT_VALID_FIELD_VALIDATION')]
    private string $value;

    public function __construct(
        Request $request,
    ) {
        $content = $request->toArray();

        $this->value = $content['values'];
    }

    public function getValues(): string
    {
        return $this->value;
    }
}
