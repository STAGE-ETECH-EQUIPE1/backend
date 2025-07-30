<?php

namespace App\MessageHandler\Branding;

use App\Message\Branding\RegenerateLogoMessage;
use App\Services\LogoGeneration\LogoGenerationServiceInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class RegenerateLogoMessageHandler
{

    public function __construct(
        private readonly LogoGenerationServiceInterface $logoGenerationService,
    ) {
    }

    public function __invoke(
        RegenerateLogoMessage $message,
    ): void {
        $this->logoGenerationService->generateNewLogoFromExistingBrandingProject(
            $message
        );
    }
}
