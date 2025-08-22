<?php

namespace App\Utils\Paginator;

use App\DTO\PaginationDTO;

final class PaginatorUtils
{
    /**
     * Build Pagination Response.
     */
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

    /**
     * Get array Value.
     */
    public static function getArrayValue(array $orderColumns, int $arrayIndex): string
    {
        if (array_key_exists($arrayIndex, $orderColumns)) {
            return $orderColumns[$arrayIndex];
        }

        return 'id';
    }
}
