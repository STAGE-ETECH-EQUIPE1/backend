<?php

namespace App\Utils\Paginator;

use App\DTO\PaginationDTO;

final class PaginatorUtils
{
    public static function buildPageResponse(
        PaginationDTO $pagination,
        int $totalElements,
    ): array {
        return [
            'currentPage' => $pagination->page,
            'nextPage' => $pagination->page + 1,
            'previousPage' => $pagination->page - 1,
            'totalElements' => $totalElements,
            'totalPages' => ceil($totalElements / $pagination->page),
        ];
    }
}
