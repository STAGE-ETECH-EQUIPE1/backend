<?php

namespace App\Services\CompanyToneOfVoice;

use App\Request\BrandingVerbal\CompanyToneOfVoiceRequest;

interface CompanyToneOfVoiceGeneratorServiceInterface
{
    public function generateToneOfVoice(CompanyToneOfVoiceRequest $request): array;
}
