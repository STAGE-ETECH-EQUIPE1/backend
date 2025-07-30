<?php

namespace App\Services\Branding;

use App\DTO\Branding\DesignBriefDTO;
use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\DesignBrief;
use App\Enum\BrandingStatus;
use App\Repository\Branding\BrandingProjectRepository;
use App\Services\AbstractService;
use App\Services\Client\ClientServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

final class BrandingService extends AbstractService implements BrandingServiceInterface
{
    public function __construct(
        private readonly ClientServiceInterface $clientService,
        private readonly EntityManagerInterface $entityManager,
        private readonly BrandingProjectRepository $brandingProjectRepository,
    ) {
    }

    public function createNewBrandingProject(DesignBriefDTO $designBriefDTO): DesignBrief
    {
        $project = (new BrandingProject())
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
            ->setMoodBoardUrl($designBriefDTO->getMoodBoardUrl())
            ->setLogoStyle($designBriefDTO->getLogoStyle())
            ->setBrandKeywords($designBriefDTO->getBrandKeywords())
            ->setSlogan($designBriefDTO->getSlogan())
            ->setBranding($project)
        ;

        $this->entityManager->persist($brief);
        $this->entityManager->flush();

        return $brief;
    }

    public function submitDesignBriefByBrandingProjectId(BrandingProject $brandingProject, DesignBriefDTO $designBriefDTO): DesignBrief
    {
        $brief = (new DesignBrief())
            ->setColorPreferences($designBriefDTO->getColorPreferences())
            ->setDescription($designBriefDTO->getDescription())
            ->setMoodBoardUrl($designBriefDTO->getMoodBoardUrl())
            ->setLogoStyle($designBriefDTO->getLogoStyle())
            ->setBrandKeywords($designBriefDTO->getBrandKeywords())
            ->setSlogan($designBriefDTO->getSlogan())
            ->setBranding($brandingProject)
        ;

        $this->entityManager->persist($brief);
        $this->entityManager->flush();

        return $brief;
    }
}
