<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'app_home_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', []);
    }

    #[Route('/api/test', name: 'api_test_endpoint', methods: ['GET'])]
    public function testServer(): JsonResponse
    {
        return $this->json([
            'message' => 'Hello From Backend',
        ], Response::HTTP_OK);
    }
}
