<?php

namespace App\Services\TokenManager;

use App\Entity\Auth\Client;
use App\Entity\Auth\UserTokens;
use App\Services\Client\ClientServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class TokenManagerService implements TokenManagerServiceInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ClientServiceInterface $clientService,
    ) {
    }

    public function hasToken(string $serviceName): bool
    {
        $userTokens = $this->getUserTokens();

        return match ($serviceName) {
            'company_name_tokens' => $userTokens->getCompanyNameTokens() > 0,
            'color_palette_tokens' => $userTokens->getColorPaletteTokens() > 0,
            'typography_tokens' => $userTokens->getTypographyTokens() > 0,
            'ton_voice_tokens' => $userTokens->getTonVoiceTokens() > 0,
            'values_tokens' => $userTokens->getValuesTokens() > 0,
            'slogan_tokens' => $userTokens->getSloganTokens() > 0,
            'logo_generation_tokens' => $userTokens->getLogoGenerationTokens() > 0,
            default => false,
        };
    }

    public function getToken(string $serviceName): int
    {
        $userTokens = $this->getUserTokens();

        try {
            switch ($serviceName) {
                case 'company_name_tokens':
                    return $userTokens->getCompanyNameTokens();
                case 'color_palette_tokens':
                    return $userTokens->getColorPaletteTokens();
                case 'typography_tokens':
                    return $userTokens->getTypographyTokens();
                case 'ton_voice_tokens':
                    return $userTokens->getTonVoiceTokens();
                case 'values_tokens':
                    return $userTokens->getValuesTokens();
                case 'slogan_tokens':
                    return $userTokens->getSloganTokens();
                case 'logo_generation_tokens':
                    return $userTokens->getLogoGenerationTokens();
            }
        } catch (\Throwable $th) {
        }

        return 0;
    }

    public function decrementToken(string $serviceName): int
    {
        $userTokens = $this->getUserTokens();
        $value = 0;

        try {
            switch ($serviceName) {
                case 'company_name_tokens':
                    $value = $userTokens
                        ->decrementCompanyNameTokens()
                        ->getCompanyNameTokens();
                    break;
                case 'color_palette_tokens':
                    $value = $userTokens
                        ->decrementColorPaletteTokens()
                        ->getColorPaletteTokens();
                    break;
                case 'typography_tokens':
                    $value = $userTokens
                        ->decrementTypographyTokens()
                        ->getTypographyTokens();
                    break;
                case 'ton_voice_tokens':
                    $value = $userTokens
                        ->decrementTonVoiceTokens()
                        ->getTonVoiceTokens();
                    break;
                case 'values_tokens':
                    $value = $userTokens
                        ->decrementValuesTokens()
                        ->getValuesTokens();
                    break;
                case 'slogan_tokens':
                    $value = $userTokens
                        ->decrementSloganTokens()
                        ->getSloganTokens();
                    break;
                case 'logo_generation_tokens':
                    $value = $userTokens
                        ->decrementLogoGenerationTokens()
                        ->getLogoGenerationTokens();
            }
            $this->entityManager->persist($userTokens);
            $this->entityManager->flush();
        } catch (\Throwable $th) {
        }

        return $value;
    }

    public function getAllTokens(): UserTokens
    {
        $client = $this->clientService->getConnectedUserClient();

        $userTokens = $client->getUserTokens();
        if ($userTokens) {
            return $userTokens;
        }

        return $this->initializeTokenForClient($client);
    }

    public function initializeTokenForClient(Client $client): UserTokens
    {
        $userToken = (new UserTokens())
            ->setCompanyNameTokens(10)
            ->setColorPaletteTokens(10)
            ->setLogoGenerationTokens(10)
            ->setTonVoiceTokens(10)
            ->setValuesTokens(10)
            ->setTypographyTokens(10)
            ->setSloganTokens(10)
            ->setUserInfo($client)
        ;
        $this->entityManager->persist($userToken);
        $this->entityManager->flush();

        return $userToken;
    }

    private function getUserTokens(): UserTokens
    {
        $client = $this->clientService->getConnectedUserClient();
        $userTokens = $client->getUserTokens();

        if ($userTokens) {
            return $userTokens;
        }

        $this->initializeTokenForClient($client);

        throw new \RuntimeException('User has no token');
    }

    public function getLogoGenerationToken(): int
    {
        return (int) $this->getUserTokens()->getLogoGenerationTokens();
    }

    public function getCompanyNameGenerationToken(): int
    {
        return (int) $this->getUserTokens()->getCompanyNameTokens();
    }

    public function getColorPaletteGenerationToken(): int
    {
        return (int) $this->getUserTokens()->getColorPaletteTokens();
    }

    public function getTypographyGenerationToken(): int
    {
        return (int) $this->getUserTokens()->getTypographyTokens();
    }

    public function getTonVoiceGenerationToken(): int
    {
        return (int) $this->getUserTokens()->getTonVoiceTokens();
    }

    public function getValuesGenerationToken(): int
    {
        return (int) $this->getUserTokens()->getValuesTokens();
    }

    public function getSloganGenerationToken(): int
    {
        return (int) $this->getUserTokens()->getSloganTokens();
    }
}
