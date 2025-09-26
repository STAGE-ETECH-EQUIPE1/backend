<?php

namespace App\Services\VisualIdentity;

use App\Entity\Auth\Client;
use App\Exception\GenerateResponseException;
use App\Request\Branding\ColorPaletteGenerationRequest;
use App\Request\Branding\TypographieGenerationRequest;
use App\Request\Branding\VisualIdentityRequest;
use App\Services\Client\ClientServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class VisualIdentityService implements VisualIdentityServiceInterface
{
    public function __construct(
        private readonly ClientServiceInterface $clientService,
        private readonly HttpClientInterface $httpClient,
        private readonly EntityManagerInterface $entityManager,
        #[Autowire('%app.gemini_api_key%')]
        private readonly string $googleAiToken,
        #[Autowire('%app.gemini_api_url%')]
        private readonly string $googleAiUrl,
    ) {
    }

    public function generateColorPalettes(ColorPaletteGenerationRequest $request): array
    {
        try {
            $response = $this->getResponseFromGeminiAi(
                $this->buildPromptForColorPalettesGeneration($request)
            );

            return $this->parseResponseTextFromAiToColorPalettesResponses(
                $this->getResponseTextFromGeminiAi($response)
            );
        } catch (\Throwable $th) {
            throw new GenerateResponseException($th);
        }
    }

    public function generateTypographies(TypographieGenerationRequest $request): array
    {
        try {
            $response = $this->getResponseFromGeminiAi(
                $this->buildPromptForTypographiesGeneration($request)
            );

            return $this->parseResponseTextFromAiToTypographieResponse(
                $this->getResponseTextFromGeminiAi($response)
            );
        } catch (\Throwable $th) {
            throw new GenerateResponseException($th);
        }
    }

    public function submitColorPalette(Request $request): Client
    {
        $client = $this->clientService->getConnectedUserClient();
        $data = $request->toArray()['colors'];

        $client->setColorPreferences($data);

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }

    public function submitTypographie(VisualIdentityRequest $request): Client
    {
        $client = $this->clientService->getConnectedUserClient();

        $client->setTypographie($request->getData());

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }

    private function getResponseTextFromGeminiAi(ResponseInterface $response): string
    {
        foreach ($response->toArray()['candidates'][0]['content']['parts'] as $part) {
            if (array_key_exists('text', $part)) {
                return $part['text'];
            }
        }

        return '';
    }

    private function parseResponseTextFromAiToColorPalettesResponses(string $textResponse): array
    {
        $paletteBlocks = preg_split('/\n\s*\n/', $textResponse);

        $allPalettes = [];

        if (is_array($paletteBlocks)) {
            foreach ($paletteBlocks as $block) {
                $block = trim($block);
                if (!str_starts_with($block, 'Palette')) {
                    continue;
                }
                $lines = explode("\n", $block);
                $firstLine = array_shift($lines);
                if (!preg_match('/Palette \d+: (.*)/', $firstLine, $nameMatches)) {
                    continue;
                }
                $paletteName = trim($nameMatches[1]);
                $colorsArray = [];
                foreach ($lines as $line) {
                    if (preg_match('/(.*?): #([a-fA-F0-9]{6}) \((.*?)\)/', $line, $colorMatches)) {
                        $colorsArray[] = [
                            'name' => trim($colorMatches[3]),
                            'position' => trim($colorMatches[1]),
                            'hex' => '#'.$colorMatches[2],
                        ];
                    }
                }
                if (!empty($colorsArray)) {
                    $allPalettes[] = [
                        'name' => $paletteName,
                        'colors' => $colorsArray,
                    ];
                }
            }
        }

        return $allPalettes;
    }

    private function parseResponseTextFromAiToTypographieResponse(string $textResponse): array
    {
        $text = (string) preg_replace('/^.*?:\n\n/', '', $textResponse, 1);
        $sections = preg_split('/(?=\n\n[A-Za-z\-\/]+ Fonts)/', $text);

        $allData = [];
        if (is_array($sections)) {
            foreach ($sections as $section) {
                $sectionLines = explode("\n", trim($section));
                $fontType = trim(array_shift($sectionLines));
                $fontsData = [];
                $currentFont = null;
                foreach ($sectionLines as $line) {
                    $trimmedLine = trim($line);
                    if (empty($trimmedLine)) {
                        continue;
                    }

                    if (str_starts_with($trimmedLine, 'Relevance:')) {
                        $currentFont['Relevance'] = substr($trimmedLine, strlen('Relevance: '));
                    } elseif (str_starts_with($trimmedLine, 'Impact:')) {
                        $currentFont['Impact'] = substr($trimmedLine, strlen('Impact: '));
                        $fontsData[] = $currentFont;
                        $currentFont = null;
                    } else {
                        $currentFont = [
                            'name' => $trimmedLine,
                            'Relevance' => '',
                            'Impact' => '',
                        ];
                    }
                }

                $allData[] = [
                    'font-type' => $fontType,
                    'fonts' => $fontsData,
                ];
            }
        }

        return $allData;
    }

    private function getResponseFromGeminiAi(string $promptText): ResponseInterface
    {
        return $this->httpClient->request(
            'POST',
            "{$this->googleAiUrl}/gemini-2.5-flash:generateContent",
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
                                    'text' => $promptText,
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        );
    }

    private function buildPromptForColorPalettesGeneration(ColorPaletteGenerationRequest $colorPalette): string
    {
        $client = $this->clientService->getConnectedUserClient();

        /** @var string $publicTarget */
        $publicTarget = $client->getPublicTarget();
        $colorFavoriteString = implode(', ', $colorPalette->getColorFavorites());
        $colorExceptString = implode(', ', $colorPalette->getColorExcepts());

        return <<<PROMPT
        Generate several color palettes aimed at a {$publicTarget} audience.
        The palettes must have a {$colorPalette->getStyleSearch()} style and evoke an emotion of {$colorPalette->getEmotion()}.
        Each palette must contain {$colorPalette->getColorNumber()} colors, and must include the following tones: {$colorFavoriteString}.
        Ensure the following colors are not used: {$colorExceptString}.

        Each palette must be presented using the strict format below:

        Palette [Number]: [Palette Name]
        Color 1: #[hex code] (Color Name)
        Color 2: #[hex code] (Color Name)
        ...
        PROMPT;
    }

    private function buildPromptForTypographiesGeneration(TypographieGenerationRequest $typographieRequest): string
    {
        $client = $this->clientService->getConnectedUserClient();

        /** @var string $publicTarget */
        $publicTarget = $client->getPublicTarget();
        /** @var string $companyArea */
        $companyArea = $client->getCompanyArea();

        return <<<PROMPT
        Generate a list of appropriate font and typography styles for a visual identity with a {$typographieRequest->getStyleSearch()} style in the {$companyArea} sector.
        The typography must also resonate with a {$publicTarget} target audience.

        The response must be structured exactly as in the example below:

        [Font style name, e.g., Serif, Sans-Serif]
        [Font Name]
        Relevance: [Explanation of the font's relevance to the style, sector, and target audience.]
        Impact: [Description of the effect the font will have on the brand.]
        [Another font style name, e.g., Script, Display]
        [Font Name]
        Relevance: [Explanation of the font's relevance to the style, sector, and target audience.]
        Impact: [Description of the effect the font will have on the brand.]
        ...
        PROMPT;
    }
}
