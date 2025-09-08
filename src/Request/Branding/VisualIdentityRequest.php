<?php

namespace App\Request\Branding;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class VisualIdentityRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    private mixed $data;

    public function __construct(Request $request)
    {
        $this->data = $request->query->get('data');
    }

    /**
     * Get the value of data.
     */
    public function getData(): mixed
    {
        return $this->data;
    }
}
