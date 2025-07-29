<?php

namespace App\Services\Branding;

use App\DTO\Branding\DesignBriefDTO;
use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\DesignBrief;
use App\Enum\BrandingStatus;
use App\Services\AbstractService;
use App\Services\Client\ClientServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

final class BrandingService extends AbstractService implements BrandingServiceInterface
{
    public function __construct(
        private readonly ClientServiceInterface $clientService,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function createNewBrandingProject(DesignBriefDTO $designBriefDTO): DesignBrief
    {
        $project = (new BrandingProject())
            ->setName($designBriefDTO->getCompanyName())
            ->setStatus(BrandingStatus::ACTIVE)
            ->setDescription($designBriefDTO->getDescription())
            ->setClient(
                $this->clientService->getConnectedUserClient()
            )
            ->setDeadLine((new \DateTimeImmutable())->modify('+1 month'))
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable())
        ;

        $brief = (new DesignBrief())
            ->setColorPreferences($designBriefDTO->getColorPreferences())
            ->setDescription($designBriefDTO->getDescription())
            ->setBranding($project)
        ;

        $this->entityManager->persist($brief);
        $this->entityManager->flush();

        return $brief;
    }

    public function buildPromptText(DesignBriefDTO $designBrief): string
    {
        $keywords = implode(', ', $designBrief->getBrandKeywords());
        $textPreferences = '';
        foreach ($designBrief->getColorPreferences() as $preferences => $color) {
            $textPreferences .= sprintf("- %s: %s \n", $preferences, $color);
        }

        return
        <<<PROMPT
        Create a modern logo for "{$designBrief->getCompanyName()}", {$designBrief->getDescription()}
        Using these keywords : {$keywords}

        **Requirements:**
        - Incorporate an abstract globe/connection symbol
        - Use primary color #003366 (navy) and accent #FFD700 (gold)
        - Include the wordmark "GlobalBridge" in a clean, sans-serif font
        - Ensure scalability for favicon (16x16) and billboard use

        **Audience:**
        Targeting CEOs and founders (ages 30-50) of scaling tech startups in Middle Eastern markets.

        **Style References:**
        {$textPreferences}

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
