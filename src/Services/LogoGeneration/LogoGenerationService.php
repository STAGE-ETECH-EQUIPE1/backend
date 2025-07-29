<?php

namespace App\Services\LogoGeneration;

use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\DesignBrief;
use App\Message\Branding\GenerateLogoMessage;
use App\Repository\Branding\DesignBriefRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class LogoGenerationService implements LogoGenerationServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly DesignBriefRepository $designBriefRepository,
        #[Autowire('%app.gemini_api_key%')]
        private readonly string $googleAiToken,
        #[Autowire('%app.gemini_api_url%')]
        private readonly string $googleAiUrl,
        #[Autowire('%app.ai_generated_path%')]
        private readonly ?string $aiGeneratedLogoPath,
    ) {
    }

    public function generateLogoFromGoogleAiStudio(GenerateLogoMessage $message): void
    {
        $response = $this->getResponseFromLogoGoogleAiStudiologoGeneration($message);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Failed to generate logo: '.$response->getContent(false));
        }

        try {
            foreach ($response->toArray()['candidates'][0]['content']['parts'] as $part) {
                // if (array_key_exists('text', $part)) {
                //     var_dump($part['text']);
                // }
                if (array_key_exists('inlineData', $part)) {
                    // var_dump(
                    //    $part['inlineData']['mimeType'],
                    //    $part['inlineData']['data']
                    // );
                    $imageData = $part['inlineData']['data'];
                    $filesystem = new Filesystem();
                    $filesystem->dumpFile(
                        ($this->aiGeneratedLogoPath ?? 'public/generated-ai/logo/').uniqid().'.png',
                        base64_decode($imageData)
                    );
                }
            }
        } catch (\Exception $e) {
            printf('Failed to generate logo: '.$e->getMessage());
        }
    }

    private function getResponseFromLogoGoogleAiStudiologoGeneration(GenerateLogoMessage $message): ResponseInterface
    {
        /** @var DesignBrief $designBrief */
        $designBrief = $this->designBriefRepository->findOneBy([
            'id' => $message->briefId,
        ]);

        return $this->httpClient->request(
            'POST',
            "{$this->googleAiUrl}/gemini-2.0-flash-preview-image-generation:generateContent",
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'X-goog-api-key' => $this->googleAiToken,
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $this->buildPrompt($designBrief),
                                ],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'responseModalities' => [
                            'TEXT', 'IMAGE',
                        ],
                    ],
                ],
            ]
        );
    }

    private function buildPrompt(DesignBrief $designBrief): string
    {
        /** @var BrandingProject $branding */
        $branding = $designBrief->getBranding();
        $companyName = $branding->getName();

        return
            <<<PROMPT
            Create a modern logo for "{$companyName}", a premium digital platform that helps businesses expand internationally with branding, e-commerce setup, and legal compliance services.

            **Requirements:**
            - Incorporate an abstract globe/connection symbol
            - Use primary color #003366 (navy) and accent #FFD700 (gold)
            - Include the wordmark "GlobalBridge" in a clean, sans-serif font
            - Ensure scalability for favicon (16x16) and billboard use

            **Audience:**
            Targeting CEOs and founders (ages 30-50) of scaling tech startups in Middle Eastern markets.

            **Style References:**
            - Minimalist like Stripe's logo
            - Geometric precision of IBM's design
            - Gold accents reminiscent of Emirates Airlines

            **Technical Specs:**
            - SVG vector format
            - Transparent background
            - No photorealistic elements

            **Avoid:**
            - Cluttered designs
            - Overused symbols like handshakes
            - Gradient effects
        PROMPT;
    }
}
