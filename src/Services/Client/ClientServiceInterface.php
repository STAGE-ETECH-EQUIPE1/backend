<?php

namespace App\Services\Client;

use App\DTO\ClientDTO;
use App\Entity\Client;
use App\Entity\User;

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
}
