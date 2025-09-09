<?php

namespace App\Services\BrandingVerbal;

use App\Entity\Auth\Client;
use App\Request\BrandingVerbal\BrandingVerbalRequest;
use App\Services\Client\ClientServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class BrandingVerbalSubmitService implements BrandingVerbalSubmitServiceInterface
{
    public function __construct(
        private readonly ClientServiceInterface $clientService,
        private readonly EntityManagerInterface $em,
    ) {
    }

    public function submitCompanyName(BrandingVerbalRequest $data): Client
    {
        $client = $this->clientService->getConnectedUserClient();
        $companyName = $data->getValues();
        $client->setCompanyName($companyName);

        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }

    public function submitCompanyValues(BrandingVerbalRequest $data): Client
    {
        $client = $this->clientService->getConnectedUserClient();
        $companyValues = $data->getValues();
        $client->setQualities($companyValues);

        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }

    public function submitCompanyToneOfVoice(BrandingVerbalRequest $data): Client
    {
        $client = $this->clientService->getConnectedUserClient();
        $companyToneOfVoice = $data->getValues();
        $client->setTonVoice($companyToneOfVoice);

        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }

    public function submitCompanySlogan(BrandingVerbalRequest $data): Client
    {
        $client = $this->clientService->getConnectedUserClient();
        $slogan = $data->getValues();
        $client->setSlogan($slogan);

        $this->em->persist($client);
        $this->em->flush();

        return $client;
    }
}
