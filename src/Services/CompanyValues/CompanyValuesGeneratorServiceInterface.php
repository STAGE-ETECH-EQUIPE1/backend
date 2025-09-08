<?php

namespace App\Services\CompanyValues;

use App\Request\BrandingVerbal\CompanyValuesRequest;

interface CompanyValuesGeneratorServiceInterface
{
    public function generateCompanyValues(CompanyValuesRequest $request): array;
}
