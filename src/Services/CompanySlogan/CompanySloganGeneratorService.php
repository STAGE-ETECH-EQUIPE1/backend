<?php

namespace App\Services\CompanySlogan;

use App\Exception\GeminiApiException;
use App\Request\CompanySlogan\CompanySloganRequest;
use App\Services\CompanySlogan\CompanySloganGeneratorServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CompanySloganGeneratorService implements CompanySloganGeneratorServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly LoggerInterface $logger,
        #[Autowire('%app.gemini_api_key%')]
        private readonly string $googleAiToken,
        #[Autowire('%app.gemini_api_url%')]
        private readonly string $googleAiUrl,
    ) {}

    public function generateCompanySlogans(CompanySloganRequest $request): array
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
                            'slogan' => ['type' => 'STRING'],
                        ],
                    ],
                ],
            ],
        ];

        try {
            $response = $this->httpClient->request(
                'POST',
                $this->googleAiUrl,
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
                throw new GeminiApiException('Gemini API returned an unexpected status code: ' . $statusCode);
            }

            $rawResponse = $response->getContent();
            return $this->parseGeminiResponse($rawResponse);

        } catch (ExceptionInterface $e) {
            $this->logger->error('Failed to connect to Gemini API.', ['exception' => $e]);
            throw new GeminiApiException('Communication with Gemini API failed: ' . $e->getMessage(), 0, $e);
        }
    }

    private function buildGeminiPrompt(CompanySloganRequest $request): string
    {
        $prompt = "Génère 5 slogans percutants et professionnels.";

        if ($request->getLangue()) {
            $prompt .= " Les slogans doivent être en " . $request->getLangue() . ".";
        }
        if ($request->getTone()) {
            $prompt .= " Le ton doit être " . $request->getTone() . ".";
        }
        if ($request->getLength()) {
            $prompt .= " La longueur doit être " . $request->getLength() . ".";
        }
        if ($request->getIncludeKeywords()) {
            $prompt .= " Ils doivent inclure ces mots-clés : " . implode(', ', $request->getIncludeKeywords()) . ".";
        }
        if ($request->getExcludeKeywords()) {
            $prompt .= " Évite les mots-clés suivants : " . implode(', ', $request->getExcludeKeywords()) . ".";
        }
        if ($request->getFocus()) {
            $prompt .= " Concentre-toi sur l'aspect suivant : " . $request->getFocus() . ".";
        }
        
        $prompt .= " Fournis la réponse sous forme de tableau JSON d'objets, chaque objet ayant une seule clé 'slogan'.";

        return $prompt;
    }

    private function parseGeminiResponse(string $rawResponse): array
    {
        $generatedSlogans = [];
        $responseData = json_decode($rawResponse, true);

        if (
            isset($responseData['candidates']) &&
            is_array($responseData['candidates']) &&
            !empty($responseData['candidates'])
        ) {
            $textPart = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if ($textPart !== null) {
                $slogansArray = json_decode($textPart, true);

                if (is_array($slogansArray)) {
                    foreach ($slogansArray as $item) {
                        if (is_array($item) && isset($item['slogan']) && is_string($item['slogan'])) {
                            $generatedSlogans[] = $item['slogan'];
                        }
                    }
                }
            }
        }
        return $generatedSlogans;
    }
}
