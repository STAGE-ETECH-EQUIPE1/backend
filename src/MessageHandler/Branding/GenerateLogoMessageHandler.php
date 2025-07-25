<?php

namespace App\MessageHandler\Branding;

use App\Message\Branding\GenerateLogoMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsMessageHandler]
final class GenerateLogoMessageHandler
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ) {
    }

    public function __invoke(
        GenerateLogoMessage $generateLogoMessage,
    ): void {
        $response = $this->httpClient->request(
            'GET',
            "https://jsonplaceholder.typicode.com/posts?_limit={$generateLogoMessage->id}"
        );
    }
}
