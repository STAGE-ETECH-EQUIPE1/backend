<?php

namespace App\Services\DeletePack;

use Symfony\Component\HttpFoundation\JsonResponse;

interface DeletePackServiceInterface
{
    public function deletePackById(int $id): JsonResponse;
}