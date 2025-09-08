<?php

namespace App\Services\CompanyToneOfVoice;

use App\Request\CompanyToneOfVoice\CompanyToneOfVoiceRequest;

interface CompanyToneOfVoiceGeneratorServiceInterface
{
    public function generateToneOfVoice(CompanyToneOfVoiceRequest $request): array;
}