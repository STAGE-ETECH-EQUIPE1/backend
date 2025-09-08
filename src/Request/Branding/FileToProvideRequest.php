<?php

namespace App\Request\Branding;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class FileToProvideRequest
{
    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    private string $companyArea;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    private string $publicTarget;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    public string $mainLanguage;

    #[Assert\NotBlank(message: 'NOT_BLANK_VALIDATION')]
    public string $mainService;

    public function __construct(Request $request)
    {
        $content = $request->toArray();
        $this->companyArea = $content['companyArea'];
        $this->publicTarget = $content['publicTarget'];
        $this->mainLanguage = $content['mainLanguage'];
        $this->mainService = $content['mainService'];
    }

    /**
     * Get the value of companyArea.
     */
    public function getCompanyArea(): string
    {
        return $this->companyArea;
    }

    /**
     * Get the value of publicTarget.
     */
    public function getPublicTarget(): string
    {
        return $this->publicTarget;
    }

    /**
     * Get the value of mainLanguage.
     */
    public function getMainLanguage(): string
    {
        return $this->mainLanguage;
    }

    /**
     * Get the value of mainService.
     */
    public function getMainService(): string
    {
        return $this->mainService;
    }
}
