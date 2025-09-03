<?php

namespace App\Services\LogoVersion;

use App\DTO\Branding\ClientFeedBackDTO;
use App\DTO\Branding\LogoVersionDTO;
use App\DTO\PaginationDTO;
use App\Entity\Branding\BrandingProject;
use App\Entity\Branding\ClientFeedBack;
use App\Entity\Branding\LogoVersion;
use App\Repository\Branding\ClientFeedBackRepository;
use App\Repository\Branding\LogoVersionRepository;
use App\Request\Logo\CommentLogoRequest;
use App\Services\AbstractService;
use App\Services\Client\ClientServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

final class LogoVersionService extends AbstractService implements LogoVersionServiceInterface
{
    public function __construct(
        private readonly LogoVersionRepository $logoVersionRepository,
        private readonly ClientFeedBackRepository $clientFeedBackRepository,
        private readonly ClientServiceInterface $clientService,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getLogoByBrandingId(BrandingProject $brandingProject): array
    {
        return $this->logoVersionRepository->findBy([
            'branding' => $brandingProject,
        ]);
    }

    public function getPaginatedLogoByBrandingId(int $brandingId, PaginationDTO $pagination): array
    {
        $paginatedResult = $this->logoVersionRepository->paginateByBrandingId($brandingId, $pagination);

        return [
            $paginatedResult->getQuery()->getResult(),
            $paginatedResult->count(),
        ];
    }

    public function getLogoFeedBackByLogoId(int $id): array
    {
        return $this->clientFeedBackRepository->findByLogoId($id);
    }

    public function paginateLogoFeedBackByLogoId(int $logoId, PaginationDTO $pagination): array
    {
        $paginatedResults = $this->clientFeedBackRepository->paginateByLogoId($logoId, $pagination);

        return [
            $paginatedResults->getQuery()->getResult(),
            $paginatedResults->count(),
        ];
    }

    public function commentLogo(LogoVersion $logo, CommentLogoRequest $comment): void
    {
        $client = $this->clientService->getConnectedUserClient();
        $feedBack = (new ClientFeedBack())
            ->setClient($client)
            ->setComment($comment->getComment())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setLogoVersion($logo)
        ;
        $this->persistEntity($feedBack);
    }

    public function convertToDTO(LogoVersion $logoVersion): LogoVersionDTO
    {
        return (new LogoVersionDTO())
            ->setId((int) $logoVersion->getId())
            ->setAssertUrl((string) $logoVersion->getAssetUrl())
            ->setApprovedAt($logoVersion->getApprovedAt() ?? new \DateTimeImmutable())
            ->setCreatedAt($logoVersion->getCreatedAt() ?? new \DateTimeImmutable())
        ;
    }

    public function convertAllToDTO(array $logoVersions): array
    {
        return array_map(
            fn ($logoVersion): LogoVersionDTO => $this->convertToDto($logoVersion),
            $logoVersions
        );
    }

    public function convertClientFeedBackToDTO(ClientFeedBack $clientFeedBack): ClientFeedBackDTO
    {
        return (new ClientFeedBackDTO())
            ->setId((int) $clientFeedBack->getId())
            ->setCreatedAt($clientFeedBack->getCreatedAt() ?? new \DateTimeImmutable())
            ->setComment((string) $clientFeedBack->getComment())
        ;
    }

    public function convertAllClientFeedBacksToDTO(array $clientFeedBacks): array
    {
        return array_map(
            fn ($clientFeedBack): ClientFeedBackDTO => $this->convertClientFeedBackToDTO($clientFeedBack),
            $clientFeedBacks
        );
    }

    private function persistEntity(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
}
