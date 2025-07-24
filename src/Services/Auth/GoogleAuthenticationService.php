<?php

namespace App\Services\Auth;

use App\DTO\Request\GoogleAuthenticationDTO;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Firebase\JWT\JWT;
use Firebase\JWT\JWK;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class GoogleAuthenticationService
{
    public function __construct(
        private EntityManagerInterface $em,
        private JWTTokenManagerInterface $jwtManager,
    ) {
    }

    public function authenticate(GoogleAuthenticationDTO $dto): string
    {
        $idToken = $dto->idToken;

        $keysJson = file_get_contents('https://www.googleapis.com/oauth2/v3/certs');
        if (!$keysJson) {
            throw new \RuntimeException('Impossible de récupérer les clés publiques Google.');
        }

        $keys = json_decode($keysJson, true);
        if (!is_array($keys)) {
            throw new \RuntimeException('Les clés Google sont invalides.');
        }

        $decoded = JWT::decode($idToken, JWK::parseKeySet($keys), ['RS256']);
        if ($decoded->aud !== $_ENV['GOOGLE_CLIENT_ID']) {
            throw new \Exception('Audience invalide pour le token Google');
        }

        $email = $decoded->email ?? null;
        if (!is_string($email)) {
            throw new \InvalidArgumentException('Le champ email est manquant ou invalide');
        }

        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $email]);

        if (!$user) {
            $user = (new User())
                ->setEmail($email)
                ->setFullName($decoded->name ?? '')
                ->setUsername($email)
                ->setPassword('') 
                ->setPhone('');

            $this->em->persist($user);
            $this->em->flush();
        }

        return $this->jwtManager->create($user);
    }
}
