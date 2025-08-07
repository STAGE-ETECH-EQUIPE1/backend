<?php

namespace App\Services\Client;

use App\DTO\User\ClientDTO;
use App\Entity\Auth\Client;
use App\Entity\Auth\User;
use App\Exception\ClientNotAssociedException;
use App\Services\AbstractService;
use App\Services\User\UserServiceInterface;
use Symfony\Bundle\SecurityBundle\Security;

final class ClientService extends AbstractService implements ClientServiceInterface
{
    public function __construct(
        private readonly Security $security,
        private readonly UserServiceInterface $userService,
    ) {
    }

    public function getConnectedUserClient(): Client
    {
        if ($this->getConnectedUser()->getClient()) {
            return $this->getConnectedUser()->getClient();
        }

        throw new \RuntimeException('No connected user found.');
    }

    private function getConnectedUser(): User
    {
        /** @var User|null $currentUser */
        $currentUser = $this->security->getUser();
        if ($currentUser) {
            return $this->userService->getById($currentUser->getId() ?? 0);
        }
        throw new \RuntimeException('No connected user found.');
    }

    public function convertUserClientToClientDTO(User $clientUser): ClientDTO
    {
        $client = $clientUser->getClient();
        if (!$client) {
            throw new ClientNotAssociedException();
        }

        return (new ClientDTO())
            ->setId((int) $clientUser->getId())
            ->setEmail((string) $clientUser->getEmail())
            ->setUsername((string) $clientUser->getUsername())
            ->setFullName((string) $clientUser->getFullName())
            ->setPhone((string) $clientUser->getPhone())
            ->setCreatedAt($clientUser->getCreatedAt() ?? new \DateTimeImmutable())
            ->setCompanyName((string) $client->getCompanyName())
        ;
    }
}
