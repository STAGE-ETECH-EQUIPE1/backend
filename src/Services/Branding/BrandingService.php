<?php

namespace App\Services\Branding;

use App\Message\Branding\GenerateLogoMessage;
use App\Services\AbstractService;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class BrandingService extends AbstractService implements BrandingServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        #[Autowire('%app.google_ai_token%')]
        private readonly string $googleAiToken,
        #[Autowire('%app.google_ai_url%')]
        private readonly string $googleAiUrl,
    ) {
    }

    public function generateLogoFromGoogleAiStudio(GenerateLogoMessage $message): void
    {
        $response = $this->getResponseFromLogoGoogleAiStudiologoGeneration($message);

        dd($response->toArray());
        // if ($response->getStatusCode() !== 200) {
        //     throw new \RuntimeException('Failed to generate logo: ' . $response->getContent(false));
        // }

        // $content = $response->toArray();
        // $imageData = $content['candidates'][0]['content']['parts'][0]['text'];
    }

    private function getResponseFromLogoGoogleAiStudiologoGeneration(GenerateLogoMessage $message): ResponseInterface
    {
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
                                    'text' => $this->buildPrompt(),
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

    private function buildPrompt(): string
    {
        return
        <<<PROMPT
            Create a modern logo for "GlobalBridge", a premium digital platform that helps businesses expand internationally with branding, e-commerce setup, and legal compliance services.

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
