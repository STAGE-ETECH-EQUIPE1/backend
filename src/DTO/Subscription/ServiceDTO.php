<?php

namespace App\DTO\Subscription;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

class ServiceDTO
{
    #[Groups(['list'])]
    public int $id;

    #[Assert\NotBlank(groups: ['create', 'update'])]
    #[Assert\Type('string', groups: ['create', 'update'])]
    #[Groups(['list', 'create', 'update'])]
    public string $name;

    #[Assert\NotBlank(groups: ['create', 'update'])]
    #[Assert\Regex(
        pattern: '/^\d{1,8}(\.\d{1,2})?$/',
        message: 'Le prix doit contenir au maximum 8 chiffres avant la virgule et 2 après.',
        groups: ['create', 'update']
    )]
    #[Groups(['list', 'create', 'update'])]
    public string $price;
}