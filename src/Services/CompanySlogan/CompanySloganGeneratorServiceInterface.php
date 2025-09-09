<?php

namespace App\Services\CompanySlogan;

use App\Request\BrandingVerbal\CompanySloganRequest;

interface CompanySloganGeneratorServiceInterface
{
    public function generateCompanySlogans(CompanySloganRequest $request): array;
}
