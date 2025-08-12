<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class PaginationDTO
{
    #[Assert\Positive()]
    public int $page = 1;

    #[Assert\Positive()]
    #[Assert\Email]
    public int $size = 10;

    public ?string $orderColumn = null;

    #[Assert\Choice(choices: ['asc', 'desc', 'ASC', 'DESC'])]
    public ?string $orderDir = null;
}
