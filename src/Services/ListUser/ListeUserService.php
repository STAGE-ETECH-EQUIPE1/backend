<?php

namespace App\Services\ListUser;

use App\Repository\Auth\UserRepository;

class ListeUserService implements ListeUserServiceInterface
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAllUsers(): array
    {
        $users = $this->userRepository->findAll();
        $resultat = [];

        foreach ($users as $user) {
            if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
                continue;
            }

            $client = $user->getClient();
            $subscriptions = $client?->getSubscriptions() ?? [];
            $subsArray = [];
            $subsArrayPack = [];

            foreach ($subscriptions as $subscription) {
                $subsArray[] = $subscription->getName();
                $pack = $subscription->getPack();
                $subsArrayPack[] = $pack?->getName();
            }

            $resultat[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
                'fullName' => $user->getFullName(),
                'username' => $user->getUsername(),
                'phone' => $user->getPhone(),
                'subscriptions' => $subsArray,
                'packName' => $subsArrayPack,
            ];
        }

        return $resultat;
    }
}
