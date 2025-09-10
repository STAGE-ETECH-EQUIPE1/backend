<?php

namespace App\Services\CompanyName;

use App\Exception\GeminiApiException;
use App\Request\BrandingVerbal\CompanyNameRequest;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CompanyNameGeneratorService implements CompanyNameGeneratorServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        #[Autowire('%app.gemini_api_key%')]
        private readonly string $googleAiToken,
        #[Autowire('%app.gemini_api_url%')]
        private readonly string $googleAiUrl,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function generateCompanyNames(CompanyNameRequest $request): array
    {
        $prompt = $this->buildGeminiPrompt($request);
        $payload = [
            'contents' => [
                ['parts' => [['text' => $prompt]]],
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
                'responseSchema' => [
                    'type' => 'ARRAY',
                    'items' => [
                        'type' => 'OBJECT',
                        'properties' => [
                            'name' => ['type' => 'STRING'],
                        ],
                    ],
                ],
            ],
        ];

        try {
            $response = $this->httpClient->request(
                'POST',
                "{$this->googleAiUrl}/gemini-2.5-flash:generateContent",
                [
                    'query' => ['key' => $this->googleAiToken],
                    'json' => $payload,
                ]
            );

            $statusCode = $response->getStatusCode();
            if ($statusCode !== 200) {
                $this->logger->error('Gemini API returned an error.', [
                    'status_code' => $statusCode,
                    'response_body' => $response->getContent(false),
                ]);
                throw new GeminiApiException('Gemini API returned an unexpected status code: '.$statusCode);
            }

            $rawResponse = $response->getContent();

            return $this->parseGeminiResponse($rawResponse);
        } catch (ExceptionInterface $e) {
            $this->logger->error('Failed to connect to Gemini API.', ['exception' => $e]);
            throw new GeminiApiException('Communication with Gemini API failed: '.$e->getMessage());
        }
    }

    private function buildGeminiPrompt(CompanyNameRequest $request): string
    {
        $prompt = "Génère une liste de noms d'entreprise créatifs, professionnels et pertinents.";

        if ($request->getIncludeKeywords()) {
            $prompt .= ' Les noms doivent inclure les mots-clés suivants : '.implode(', ', $request->getIncludeKeywords()).'.';
        }

        if ($request->getExcludeKeywords()) {
            $prompt .= ' Évite les noms contenant ces mots-clés : '.implode(', ', $request->getExcludeKeywords()).'.';
        }

        if ($request->getLength()) {
            $prompt .= ' La longueur préférée des noms est : '.$request->getLength().'.';
        }

        if ($request->getStyle()) {
            $prompt .= ' Le style souhaité pour les noms est : '.$request->getStyle().'.';
        }

        if ($request->getLangue()) {
            $prompt .= ' La langue des noms doit être : '.$request->getLangue().'.';
        }

        if ($request->isCheckSocialMedia()) {
            $prompt .= " Suggère des noms qui ont une forte probabilité d'être disponibles sur les réseaux sociaux.";
        }

        $prompt .= "\n\nFournis les noms sous la forme d'un tableau JSON d'objets, chaque objet ayant une seule clé 'name'.";

        return $prompt;
    }

    private function parseGeminiResponse(string $rawResponse): array
    {
        $generatedNames = [];
        $responseData = json_decode($rawResponse, true);

        if (
            isset($responseData['candidates'])
            && is_array($responseData['candidates'])
            && !empty($responseData['candidates'])
        ) {
            $textPart = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if ($textPart !== null) {
                $namesArray = json_decode($textPart, true);

                if (is_array($namesArray)) {
                    foreach ($namesArray as $item) {
                        if (is_array($item) && isset($item['name']) && is_string($item['name'])) {
                            $generatedNames[] = $item['name'];
                        }
                    }
                } else {
                    $this->logger->warning('Gemini response text could not be parsed as an array.', ['response' => $textPart]);
                }
            } else {
                $this->logger->warning('Text part not found in Gemini response.', ['response' => $responseData]);
            }
        } else {
            $this->logger->error('Invalid or empty candidates found in Gemini response.', ['response' => $responseData]);
        }

        return $generatedNames;
    }
}
