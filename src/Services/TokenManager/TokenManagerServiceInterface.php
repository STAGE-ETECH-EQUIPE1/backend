<?php

namespace App\Services\TokenManager;

use App\Entity\Auth\Client;
use App\Entity\Auth\UserTokens;

interface TokenManagerServiceInterface
{
    public function hasToken(string $serviceName): bool;

    public function getToken(string $serviceName): int;

    public function decrementToken(string $serviceName): int;

    public function getAllTokens(): UserTokens;

    public function initializeTokenForClient(Client $client): UserTokens;

    public function getLogoGenerationToken(): int;

    public function getCompanyNameGenerationToken(): int;

    public function getColorPaletteGenerationToken(): int;

    public function getTypographyGenerationToken(): int;

    public function getTonVoiceGenerationToken(): int;

    public function getValuesGenerationToken(): int;

    public function getSloganGenerationToken(): int;
}
