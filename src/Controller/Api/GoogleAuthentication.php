<?php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GoogleAuthenticationController extends AbstractController
{
    // 1. Démarrer l’authentification : redirection vers Google
    #[Route('/connect/google', name: 'connect_google_start')]
    public function connectAction(ClientRegistry $clientRegistry)
    {
        // les scopes dont tu as besoin
        $scopes = ['openid', 'email', 'profile'];

        // redirige vers Google pour autorisation
        return $clientRegistry->getClient('google')->redirect($scopes);
    }

    // 2. Le callback après la connexion Google
    #[Route('/connect/google/check', name: 'connect_google_check')]
    public function connectCheckAction(
        ClientRegistry $clientRegistry,
        EntityManagerInterface $em,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        try {
            // récupérer le client Google
            $client = $clientRegistry->getClient('google');

            // récupérer l'utilisateur Google
            /** @var \League\OAuth2\Client\Provider\GoogleUser $googleUser */
            $googleUser = $client->fetchUser();

            $email = $googleUser->getEmail();

            // chercher ou créer l'utilisateur en base
            $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
            if (!$user) {
                $user = new User();
                $user->setEmail($email);
                $user->setFullName($googleUser->getName());
                $user->setPassword(''); // ou gérer autrement
                $em->persist($user);
                $em->flush();
            }

            // créer un JWT pour l’utilisateur
            $token = $jwtManager->create($user);

            return new JsonResponse(['token' => $token]);
        } catch (IdentityProviderException $e) {
            return new JsonResponse([
                'error' => 'OAuth error',
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
