<?php

namespace App\Services\Auth;

use App\DTO\Request\GoogleAuthenticationDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Token\AccessToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class GoogleAuthenticationService
{
    public function __construct(
        private ClientRegistry $clientRegistry,
        private EntityManagerInterface $em,
        private JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public function authenticate(GoogleAuthenticationDTO $dto): string
    {
        $client = $this->clientRegistry->getClient('google');
        $accessToken = new AccessToken(['access_token' => $dto->accessToken]);
        $googleUser = $client->fetchUserFromToken($accessToken);

        /** @var \League\OAuth2\Client\Provider\GoogleUser $googleUser */
        $email = $googleUser->getEmail();

        if (!is_string($email)) {
            throw new \InvalidArgumentException('Email must be a string');
        }
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $user = new User();
            $user->setEmail($email);
            $user->setFullName('');
            $user->setUsername('');
            $user->setPassword('');
            $user->setPhone('');

            $this->em->persist($user);
            $this->em->flush();
        }

        return $this->jwtManager->create($user);
    }
}
