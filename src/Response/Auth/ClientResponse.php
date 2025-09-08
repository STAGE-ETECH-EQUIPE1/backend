<?php

namespace App\Response\Auth;

use App\Entity\Auth\Client;

class ClientResponse
{
    private int $id;

    private string $companyName;

    private string $companyArea;

    private string $slogan;

    private string $tonVoice;

    /** @var string[] */
    private array $qualities;

    private string $publicTarget;

    private string $mainLanguage;

    private string $mainService;

    private string $typographie;

    /** @var string[] */
    private array $colorPalette;

    public function __construct(Client $client)
    {
        $this->id = (int) $client->getId();
        $this->companyName = (string) $client->getCompanyName();
        $this->companyArea = (string) $client->getCompanyArea();
        $this->slogan = (string) $client->getSlogan();
        $this->tonVoice = (string) $client->getTonVoice();
        $this->qualities = $client->getQualities() ?? [];
        $this->publicTarget = (string) $client->getPublicTarget();
        $this->mainLanguage = (string) $client->getMainLanguage();
        $this->mainService = (string) $client->getMainService();
        $this->typographie = (string) $client->getTypographie();
        $this->colorPalette = $client->getColorPreferences() ?? [];
    }

    /**
     * Get the value of mainService.
     */
    public function getMainService(): string
    {
        return $this->mainService;
    }

    /**
     * Get the value of mainLanguage.
     */
    public function getMainLanguage(): string
    {
        return $this->mainLanguage;
    }

    /**
     * Get the value of publicTarget.
     */
    public function getPublicTarget(): string
    {
        return $this->publicTarget;
    }

    /**
     * Get the value of qualities.
     *
     * @return string[]
     */
    public function getQualities(): array
    {
        return $this->qualities;
    }

    /**
     * Get the value of tonVoice.
     */
    public function getTonVoice(): string
    {
        return $this->tonVoice;
    }

    /**
     * Get the value of slogan.
     */
    public function getSlogan(): string
    {
        return $this->slogan;
    }

    /**
     * Get the value of companyArea.
     */
    public function getCompanyArea(): string
    {
        return $this->companyArea;
    }

    /**
     * Get the value of companyName.
     */
    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    /**
     * Get the value of id.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get the value of typographie.
     */
    public function getTypographie(): string
    {
        return $this->typographie;
    }

    /**
     * @return string[]
     */
    public function getColorPalette(): array
    {
        return $this->colorPalette;
    }
}
