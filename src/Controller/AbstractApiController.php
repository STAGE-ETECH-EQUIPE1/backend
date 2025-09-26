<?php

namespace App\Controller;

use App\Services\TokenManager\TokenManagerServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AbstractApiController extends AbstractController
{
    public function __construct(
        private readonly TokenManagerServiceInterface $tokenManagerService,
    ) {
    }

    protected function handleServiceRequest(string $serviceName): bool
    {
        if ($this->tokenManagerService->hasToken($serviceName)) {
            $value = $this->tokenManagerService->decrementToken($serviceName);

            return true;
        }

        return false;
    }
}
