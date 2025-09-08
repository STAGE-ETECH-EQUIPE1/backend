<?php

namespace App\Services\CompanyToneOfVoice;

use App\Exception\GeminiApiException;
use App\Request\CompanyToneOfVoice\CompanyToneOfVoiceRequest;
use App\Services\CompanyToneOfVoice\CompanyToneOfVoiceGeneratorServiceInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CompanyToneOfVoiceGeneratorService implements CompanyToneOfVoiceGeneratorServiceInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly LoggerInterface $logger,
        #[Autowire('%app.gemini_api_key%')]
        private readonly string $googleAiToken,
        #[Autowire('%app.gemini_api_url%')]
        private readonly string $googleAiUrl,
    ) {}

    public function generateToneOfVoice(CompanyToneOfVoiceRequest $request): array
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
                            'tone_of_voice' => ['type' => 'STRING'],
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

    private function buildGeminiPrompt(CompanyToneOfVoiceRequest $request): string
    {
        $prompt = "Génère une description du ton de voix pour une marque. ";

        if ($request->getMission()) {
            $prompt .= "La mission de l'entreprise est la suivante : " . $request->getMission() . ".";
        }
        if ($request->getVision()) {
            $prompt .= "La vision de l'entreprise est : " . $request->getVision() . ".";
        }
        if ($request->getValues()) {
            $prompt .= "Basé sur les valeurs suivantes : " . implode(', ', $request->getValues()) . ".";
        }
        if ($request->getPositioning()) {
            $prompt .= "Le positionnement de l'entreprise est : " . $request->getPositioning() . ".";
        }
        if ($request->getAvoidExamples()) {
            $prompt .= "Évite les exemples de ton de voix suivants : " . implode(', ', $request->getAvoidExamples()) . ".";
        }
        if ($request->getMarketScope()) {
            $prompt .= "Le marché est " . $request->getMarketScope() . ".";
        }

        $prompt .= " Fournis la réponse sous forme de tableau JSON d'objets, chaque objet ayant une seule clé 'tone_of_voice'.";
        
        return $prompt;
    }

    private function parseGeminiResponse(string $rawResponse): array
    {
        $generatedTones = [];
        $responseData = json_decode($rawResponse, true);

        if (
            isset($responseData['candidates']) &&
            is_array($responseData['candidates']) &&
            !empty($responseData['candidates'])
        ) {
            $textPart = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if ($textPart !== null) {
                $tonesArray = json_decode($textPart, true);

                if (is_array($tonesArray)) {
                    foreach ($tonesArray as $item) {
                        if (is_array($item) && isset($item['tone_of_voice']) && is_string($item['tone_of_voice'])) {
                            $generatedTones[] = $item['tone_of_voice'];
                        }
                    }
                }
            }
        }
        return $generatedTones;
    }
}
