<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Movie;
use Psr\Log\LoggerInterface;

class MovieService
{
    /** @var EntityManagerInterface $em */
    private $em;

    /** @var LoggerInterface $logger */
    private $logger;

    protected static $MOVIES = [
        [
            "title" => "Fight Club",
            "description" => "Insomniaque, désillusionné par sa vie personnelle et professionnelle, un jeune cadre expert en assurances, mène une vie monotone et sans saveur. Face à la vacuité de son existence, son médecin lui conseille de suivre une thérapie afin de relativiser son mal-être. Lors d'un voyage d'affaires, il fait la connaissance de Tyler Durden, une sorte de gourou anarchiste et philosophe. Ensemble, ils fondent le Fight Club. Cercle très fermé, où ils organisent des combats clandestins et violents, destinés à évacuer l'ordre établi.",
            "category" => "Drame",
            "image" => "images/movies/fight_club.jpg",
        ],
        [
            "title" => "Pulp Fiction",
            "description" => "L'odyssée sanglante, burlesque et cocasse de petits malfrats dans la jungle de Hollywood à travers trois histoires qui s'entremêlent.",
            "category" => "Comédie",
            "image" => "images/movies/pulp_fiction.jpg",
        ],
        [
            "title" => "Interstellar",
            "description" => "Alors que la vie sur Terre touche à sa fin, un groupe d’explorateurs s’attelle à la mission la plus importante de l’histoire de l’humanité : franchir les limites de notre galaxie pour savoir si l’homme peut vivre sur une autre planète…",
            "category" => "Drame",
            "image" => "images/movies/interstellar.jpg",
        ],
        [
            "title" => "2001 : L'Odyssée de l'espace",
            "description" => "A l'aube de l'Humanité, dans le désert africain, une tribu de primates subit les assauts répétés d'une bande rivale, qui lui dispute un point d'eau. La découverte d'un monolithe noir inspire au chef des singes assiégés un geste inédit et décisif.
En 2001, quatre millions d'années plus tard, un vaisseau spatial évolue en orbite lunaire au rythme langoureux du \"Beau Danube Bleu\". A son bord, le Dr. Heywood Floyd enquête secrètement sur la découverte d'un monolithe noir qui émet d'étranges signaux vers Jupiter.",
            "category" => "Sciences-fiction",
            "image" => "images/movies/odyssee_espace.jpg",
        ]
    ];

    /**
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $em,
                                LoggerInterface $logger)
    {
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * @param User|null $user
     */
    public function getMoviesByUser(User $user = null)
    {
        $movieRepo = $this->em->getRepository(Movie::class);
        // If user is not logged in I return all movies
        if($user === null){
            $movies = $movieRepo->findAllInArray();

            return $movies;
        }
    }

    /**
     *
     */
    public function purgeMovies()
    {
        $movies = $this->em->getRepository(Movie::class)->findAll();

        try{
            $nbMovies = count($movies);
            if($nbMovies > 0){
                foreach ($movies as $movie) {
                    $this->em->remove($movie);
                }

                $this->em->flush();
            }
            $this->logger->notice("Purging {$nbMovies} movies successfully");
        }catch (\Exception $e){
            $this->logger->warning("Error when purging movies : {$e->getMessage()}");
        }
    }

    /**
     *
     */
    public function createDefaultMovies()
    {
        try{
            foreach (self::$MOVIES as $movieArray){
                $movie = new Movie();
                $movie->setTitle($movieArray["title"]);
                $movie->setDescription($movieArray["description"]);
                $movie->setImage($movieArray["image"]);
                $movie->setCategory($movieArray["category"]);

                $this->logger->notice("Movie '{$movie->getTitle()}' successfully created!");

                $this->em->persist($movie);
            }
            $this->em->flush();
        }catch (\Exception $e){
            $this->logger->warning("Error when creating default movies : {$e->getMessage()}");
        }
    }
}