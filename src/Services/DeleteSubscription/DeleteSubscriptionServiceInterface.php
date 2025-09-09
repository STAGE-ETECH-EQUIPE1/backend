<?php

namespace App\Services\DeleteSubscription;

use Symfony\Component\HttpFoundation\JsonResponse;

interface DeleteSubscriptionServiceInterface
{
    public function deleteSubscriptionById(int $id): JsonResponse;
}
