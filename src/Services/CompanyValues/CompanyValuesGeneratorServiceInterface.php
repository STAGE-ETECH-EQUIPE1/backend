<?php

namespace App\Services\CompanyValues;

use App\Request\CompanyValues\CompanyValuesRequest;

interface CompanyValuesGeneratorServiceInterface
{
    public function generateCompanyValues(CompanyValuesRequest $request): array;
}