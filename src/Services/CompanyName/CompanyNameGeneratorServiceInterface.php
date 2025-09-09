<?php

namespace App\Services\CompanyName;

use App\Request\BrandingVerbal\CompanyNameRequest;

interface CompanyNameGeneratorServiceInterface
{
    public function generateCompanyNames(CompanyNameRequest $request): array;
}
