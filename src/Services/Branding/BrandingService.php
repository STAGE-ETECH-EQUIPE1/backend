<?php

namespace App\Services\Branding;

use App\DTO\Branding\BrandingProjectDTO;
use App\DTO\PaginationDTO;
use App\Entity\Auth\Client;
use App\Entity\Auth\User;
use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\DesignBrief;
use App\Enum\BrandingStatus;
use App\Repository\Branding\BrandingProjectRepository;
use App\Request\Branding\DesignBriefRequest;
use App\Security\Voter\BrandingProjectVoter;
use App\Services\AbstractService;
use App\Services\Client\ClientServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

final class BrandingService extends AbstractService implements BrandingServiceInterface
{
    public function __construct(
        private readonly ClientServiceInterface $clientService,
        private readonly EntityManagerInterface $entityManager,
        private readonly BrandingProjectRepository $brandingProjectRepository,
        private readonly Security $security,
    ) {
    }

    public function getAllBrandingProject(): array
    {
        if ($this->security->isGranted(BrandingProjectVoter::LIST_ALL)) {
            return $this->brandingProjectRepository->findAll();
        }

        return $this->brandingProjectRepository->findBy([
            'client' => $this->clientService->getConnectedUserClient(),
        ]);
    }

    public function getPaginatedBrandingProject(PaginationDTO $pagination): array
    {
        $paginatedResult = $this->brandingProjectRepository->paginateByClient(
            $this->clientService->getConnectedUserClient(),
            $pagination
        );

        return [
            $paginatedResult->getQuery()->getResult(),
            $paginatedResult->count(),
        ];
    }

    public function createNewBrandingProject(DesignBriefRequest $designBriefDTO): DesignBrief
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

    public function submitDesignBriefByBrandingProjectId(BrandingProject $brandingProject, DesignBriefRequest $designBriefDTO): DesignBrief
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

    public function convertToDTO(BrandingProject $brandingProject): BrandingProjectDTO
    {
        /** @var Client $client */
        $client = $brandingProject->getClient();
        /** @var User $user */
        $user = $client->getUserInfo();

        return (new BrandingProjectDTO())
            ->setId((int) $brandingProject->getId())
            ->setStatus($brandingProject->getStatus() ?? BrandingStatus::ACTIVE)
            ->setDescription((string) $brandingProject->getDescription())
            ->setDeadLine($brandingProject->getDeadLine() ?? new \DateTimeImmutable())
            ->setCreatedAt($brandingProject->getCreatedAt() ?? new \DateTimeImmutable())
            ->setUpdatedAt($brandingProject->getUpdatedAt() ?? new \DateTimeImmutable())
        ;
    }

    public function convertAllToDTO(array $brandingProjects): array
    {
        return array_map(
            fn ($brandingProject): BrandingProjectDTO => $this->convertToDto($brandingProject),
            $brandingProjects
        );
    }
}
