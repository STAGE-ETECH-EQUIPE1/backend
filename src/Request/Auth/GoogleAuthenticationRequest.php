<?php

namespace App\Request\Auth;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class GoogleAuthenticationRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type('string', message: 'NOT_VALID_FIELD_VALIDATION')]
    private string $accessToken;

    public function __construct(
        Request $request,
    ) {
        $content = $request->toArray();
        $this->accessToken = $content['access_token'] ?? '';
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }
}
