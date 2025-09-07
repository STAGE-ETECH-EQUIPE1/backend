<?php

namespace App\Services\Client;

use App\DTO\User\ClientDTO;
use App\Entity\Auth\Client;
use App\Entity\Auth\User;
use App\Entity\Subscription\Subscription;

interface ClientServiceInterface
{
    /**
     * Get Connected User and Client.
     */
    public function getConnectedUserClient(): Client;

    /**
     * Convert User Client to ClientDTO.
     */
    public function convertUserClientToClientDTO(User $client): ClientDTO;

    /**
     * Get active Subscription for current client.
     */
    public function getSubscriptionForConnectedClient(): ?Subscription;
}
