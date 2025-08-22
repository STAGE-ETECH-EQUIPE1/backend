<?php

namespace App\Request\Subscription;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class ServiceRequest
{
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^\d{1,8}(\.\d{1,2})?$/',
        message: 'Le prix doit contenir au maximum 8 chiffres avant la virgule et 2 après.',
    )]
    private string $price;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
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
