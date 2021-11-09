<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\MovieService;

class MovieController extends AbstractController
{
    #[Route('/movies/', name: 'movies')]
    public function index(Request $request, MovieService $movieService): Response
    {
        return $this->json($movieService->getMoviesByUser($this->getUser()));
    }
}
