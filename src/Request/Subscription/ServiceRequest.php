<?php

namespace App\Request\Subscription;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ServiceRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type(type: 'string', message: 'NOT_VALID_FIELD_VALIDATION')]
    private string $name;

    #[Assert\NotNull(message: 'NOT_NULL_VALIDATION')]
    #[Assert\Regex(
        pattern: '/^\d{1,8}(\.\d{1,2})?$/',
        message: 'NOT_VALID_FIELD_VALIDATION',
    )]
    private string $price;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    #[Assert\Type(type: 'integer', message: 'NOT_VALID_FIELD_VALIDATION')]
    private int $token;

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->name = $content['name'] ?? null;
        $this->price = $content['price'] ?? null;
        $this->token = isset($content['token']) ? (int) $content['token'] : 5;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getToken(): int
    {
        return $this->token;
    }
}
