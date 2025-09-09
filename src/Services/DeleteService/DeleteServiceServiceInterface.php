<?php

namespace App\Services\DeleteService;

use Symfony\Component\HttpFoundation\JsonResponse;

interface DeleteServiceServiceInterface
{
    public function deleteServiceById(int $id): JsonResponse;
}
