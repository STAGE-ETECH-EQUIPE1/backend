<?php

namespace App\MessageHandler\Branding;

use App\Message\Branding\GenerateLogoMessage;
use App\Services\LogoGeneration\LogoGenerationServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class GenerateLogoMessageHandler
{
    public function __construct(
        private readonly LogoGenerationServiceInterface $logoGenerationService,
    ) {
    }

    public function __invoke(
        GenerateLogoMessage $message,
    ): void {
        $this->logoGenerationService->generateLogoFromGoogleAiStudio(
            $message
        );
    }
}
