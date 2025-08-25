<?php

namespace App\Services\RateLimiter;

use App\Exception\QuotaReachedException;
use App\Services\Client\ClientServiceInterface;

class RateLimiterService implements RateLimiterServiceInterface
{
    private readonly ClientServiceInterface $clientService;

    public function __construct(
        ClientServiceInterface $clientService,
    ){
        $this->clientService = $clientService;
    }

    public function tokenCount(): void
    {
        $token = 0;
        $client = $this->clientService->getConnectedUserClient();
        $tokenSent = $client->getTokendSent();
        
        foreach ($client->getSubscriptions() as $subscription) {
            foreach ($subscription->getServices() as $service) {
                $token += $service->getToken();
            }
        }

        if ($tokenSent > $token)
            throw new QuotaReachedException("your logo creation limit has been reached");
    }
}