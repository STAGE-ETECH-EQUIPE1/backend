<?php

namespace App\MessageHandler\Branding;

use App\Message\Branding\GenerateLogoMessage;
use App\Services\Branding\BrandingServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GenerateLogoMessageHandler
{
    public function __construct(
        private readonly BrandingServiceInterface $brandingService,
    ) {
    }

    public function __invoke(
        GenerateLogoMessage $message,
    ): void {
        $this->brandingService->generateLogoFromGoogleAiStudio(
            $message
        );
    }
}
