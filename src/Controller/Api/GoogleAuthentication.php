<?php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use League\OAuth2\Client\Token\AccessToken;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GoogleAuthentication extends AbstractController
{
    #[Route('/auth/google', name: 'auth_google', methods: ['POST'])]
    public function googleLogin(
        Request $request,
        ClientRegistry $clientRegistry,
        EntityManagerInterface $em,
        JWTTokenManagerInterface $jwtManager
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['access_token'])) {
            return new JsonResponse(['error' => 'access_token missing'], 400);
        }

        /** @var GoogleClient $client */
        $client = $clientRegistry->getClient('google');

        $accessToken = new AccessToken(['access_token' => $data['access_token']]);

        /** @var \League\OAuth2\Client\Provider\GoogleUser $googleUser */
        $googleUser = $client->fetchUserFromToken($accessToken);

        $email = $googleUser->getEmail();

        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);
        if (!$user) {
            $user = new User();
            $user->setEmail($email);
            $user->setFullName($googleUser->getName());
            $user->setPassword('');
            $em->persist($user);
            $em->flush();
        }

        $token = $jwtManager->create($user);

        return new JsonResponse(['token' => $token]);
    }
}
