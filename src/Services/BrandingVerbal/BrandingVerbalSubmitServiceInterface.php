<?php

namespace App\Services\BrandingVerbal;

use App\Entity\Auth\Client;
use App\Request\BrandingVerbal\BrandingVerbalRequest;

interface BrandingVerbalSubmitServiceInterface
{
    public function submitCompanyName(BrandingVerbalRequest $data): Client;

    // public function submitCompanyValues(BrandingVerbalRequest $data): Client;

    public function submitCompanySlogan(BrandingVerbalRequest $data): Client;

    public function submitCompanyToneOfVoice(BrandingVerbalRequest $data): Client;
}
