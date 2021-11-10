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
        return $this->json($movieService->getMoviesInArray());
    }

    #[Route('/movies/favourite/', name: 'handleFavorite', methods: "POST")]
    public function handleFavorite(Request $request, MovieService $movieService): Response
    {
        $content = json_decode($request->getContent());

        try{
            $movies = $movieService->handleFavourite($this->getUser(), $content->movieId, $content->action);

            return $this->json([
                "status" => true,
                "message" => null,
                "movies" => json_encode($movies),
            ]);
        }catch (\Exception $e){
            return $this->json([
                "status" => false,
                "message" => $e->getMessage()
            ]);
        }
    }
}
