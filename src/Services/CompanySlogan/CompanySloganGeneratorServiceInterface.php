<?php

namespace App\Services\CompanySlogan;

use App\Request\CompanySlogan\CompanySloganRequest;

interface CompanySloganGeneratorServiceInterface
{
    public function generateCompanySlogans(CompanySloganRequest $request): array;
}