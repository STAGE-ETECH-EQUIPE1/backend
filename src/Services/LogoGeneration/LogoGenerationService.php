<?php

namespace App\Services\LogoGeneration;

use App\Entity\Auth\Client;
use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\DesignBrief;
use App\Entity\Branding\LogoVersion;
use App\Message\Branding\GenerateLogoMessage;
use App\Message\Branding\RegenerateLogoMessage;
use App\Repository\Branding\BrandingProjectRepository;
use App\Repository\Branding\DesignBriefRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class LogoGenerationService implements LogoGenerationServiceInterface
{
    private Filesystem $filesystem;

    private const GENERATION_NUMBER = 5;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly DesignBriefRepository $designBriefRepository,
        private readonly BrandingProjectRepository $brandingProjectRepository,
        private readonly EntityManagerInterface $entityManager,
        #[Autowire('%app.gemini_api_key%')]
        private readonly string $googleAiToken,
        #[Autowire('%app.gemini_api_url%')]
        private readonly string $googleAiUrl,
        #[Autowire('%app.ai_logo_generated_path%')]
        private readonly ?string $aiGeneratedLogoPath,
    ) {
        $this->filesystem = new Filesystem();
    }

    private function encodeURLImageToBase64(string $imageUrl): ?string
    {
        try {
            $response = $this->httpClient->request('GET', $imageUrl);
            $imageContent = $response->getContent();
            $mimeTypes = new MimeTypes();

            $mimeType = $response->getHeaders()['content-type'][0] ??
                $mimeTypes->guessMimeType($imageUrl);

            if (!str_starts_with($mimeType ?? '', 'image/')) {
                return null;
            }

            return base64_encode($imageContent);
        } catch (ClientExceptionInterface) {
            return null;
        }
    }

    public function generateLogoFromGoogleAiStudio(GenerateLogoMessage $message): void
    {
        /** @var DesignBrief $designBrief */
        $designBrief = $this->designBriefRepository->findOneBy([
            'id' => $message->briefId,
        ]);

        /** @var BrandingProject $brandingProject */
        $brandingProject = $designBrief->getBranding();

        for ($i = 0; $i <= self::GENERATION_NUMBER; ++$i) {
            $response = $this->getResponseFromLogoGoogleAiStudioLogoGeneration($designBrief);
            $this->storeLogoFromGeminiAiResponse($response, $brandingProject, $designBrief);
        }

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Failed to generate logo: '.$response->getContent(false));
        }
    }

    public function generateNewLogoFromExistingBrandingProject(RegenerateLogoMessage $message): void
    {
        /** @var BrandingProject $brandingProject */
        $brandingProject = $this->brandingProjectRepository->findOneBy([
            'id' => $message->brandingId,
        ]);

        /** @var DesignBrief $designBrief */
        $designBrief = $this->designBriefRepository->findOneBy([
            'id' => $message->briefId,
        ]);

        for ($i = 0; $i <= self::GENERATION_NUMBER; ++$i) {
            $response = $this->getResponseFromLogoGoogleAiStudioLogoGeneration($designBrief);
            $this->storeLogoFromGeminiAiResponse($response, $brandingProject, $designBrief);
        }

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Failed to generate logo: '.$response->getContent(false));
        }
    }

    private function getResponseFromLogoGoogleAiStudioLogoGeneration(DesignBrief $designBrief): ResponseInterface
    {
        $moodBoardUrl = $designBrief->getMoodBoardUrl();
        $imageEncoded = $moodBoardUrl ? $this->encodeURLImageToBase64($moodBoardUrl) : null;

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
                                $imageEncoded ?
                                [
                                    'inlineData' => [
                                        'mimeType' => 'image/png',
                                        'data' => $imageEncoded,
                                    ],
                                ] : null,
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
        /** @var Client $client */
        $client = $branding->getClient();
        /** @var string $logoStyle */
        $logoStyle = $designBrief->getLogoStyle();
        $keywords = implode(',', $designBrief->getBrandKeywords());
        $slogan = $designBrief->getSlogan() ? "and with this slogan {$designBrief->getSlogan()}" : '';

        return
            <<<PROMPT
            A {$logoStyle} logo for a {$client->getCompanyArea()} company on a solid color background. Include the text {$client->getCompanyName()} {$slogan}
            there are any keywords about my company : {$keywords}
            you can use this picture from inspiration
        PROMPT;
    }

    private function storeLogoFromGeminiAiResponse(ResponseInterface $response, BrandingProject $brandingProject, DesignBrief $designBrief): void
    {
        try {
            $logo = (new LogoVersion())
                ->setCreatedAt(new \DateTimeImmutable());

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
                    $imageUrl = ($this->aiGeneratedLogoPath ?? 'public/generated-ai/logo/').((string) $brandingProject->getId()).'/'.uniqid().'.png';
                    $this->filesystem->dumpFile(
                        $imageUrl,
                        base64_decode($imageData)
                    );
                    $logo
                        ->setAssetUrl($imageUrl)
                        ->setBrief($designBrief)
                    ;
                }
            }

            $brandingProject->addLogo($logo);
            $this->entityManager->persist($brandingProject);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            printf('Failed to generate logo: '.$e->getMessage());
        }
    }
}
