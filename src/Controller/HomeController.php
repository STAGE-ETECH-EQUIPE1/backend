<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/test', name: 'test_endpoint', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        return $this->json([
            'message' => 'Hello From Backend',
        ], Response::HTTP_OK);
    }

    public function home(): Response
    {
        return $this->render('home/index.html.twig', [
            'message' => 'Welcome to the Home Page',
        ]);
    }
}