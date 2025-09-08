<?php

namespace App\Services\CompanyName;

use App\Request\CompanyName\CompanyNameRequest;

interface CompanyNameGeneratorServiceInterface
{
    public function generateCompanyNames(CompanyNameRequest $request): array;
}