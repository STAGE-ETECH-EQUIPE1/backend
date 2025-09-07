<?php

namespace App\DTO;

use Symfony\Component\Validator\Constraints as Assert;

final class PaginationDTO
{
    #[Assert\Positive()]
    public int $page = 1;

    #[Assert\Positive()]
    public int $size = 10;

    #[Assert\PositiveOrZero()]
    public int $orderColumn = 0;

    #[Assert\Choice(choices: ['asc', 'desc', 'ASC', 'DESC'])]
    public ?string $orderDir = null;

    public function getOrderColumn(): int
    {
        return $this->orderColumn ?? 0;
    }

    public function getOrderDir(): string
    {
        return $this->orderDir ?? 'ASC';
    }

    public function getOffset(): int
    {
        return ($this->page - 1) * $this->size;
    }
}
