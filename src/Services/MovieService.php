<?php

namespace App\Services;

use App\Entity\Favourite;
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
        ],
        [
            "title" => "Blade Runner",
            "description" => "2019, Los Angeles. La Terre est surpeuplée et l’humanité est partie coloniser l’espace. Les nouveaux colons sont assistés de Replicants, androïdes que rien ne peut distinguer de l'être humain. Conçus comme de nouveaux esclaves, certains parmi les plus évolués s’affranchissent de leurs chaînes et s’enfuient. Rick Deckard, un ancien Blade Runner, catégorie spéciale de policiers chargés de \"retirer\" ces replicants, accepte une nouvelle mission consistant à retrouver quatre de ces individus qui viennent de regagner la Terre après avoir volé une navette spatiale. Ces replicants sont des Nexus 6, derniers nés de la technologie développée par la Tyrell Corporation.",
            "category" => "Sciences-fiction",
            "image" => "images/movies/Blade_Runner.jpg",
        ],
        [
            "title" => "Forrest Gump",
            "description" => "A Savannah, dans l'Etat de Géorgie, Forrest Gump, assis sur un banc public, livre à qui veut l'entendre, l'étrange récit de sa vie mouvementée. Il naît dans un bourg de l'Alabama, affecté d'un quotient intellectuel inférieur à la moyenne et d'une paralysie partielle des jambes. Souvent raillé à l'école, le jeune Forrest se lie d'amitié avec la belle Jenny. Ensemble, ils vont grandir dans l'Amérique des années 1960.",
            "category" => "Drame",
            "image" => "images/movies/Forrest_Gump.jpg",
        ],
        [
            "title" => "Le Seigneur des Anneaux - Le Retour du roi",
            "description" => "Guidés par Gollum, Frodon et Sam continuent leur périple vers la montagne du destin, tandis que Gandalf et ses compagnons se retrouvent à Isengard",
            "category" => "Action",
            "image" => "images/movies/Le_Seigneur_des_Anneaux_Le_Retour_du_roi.jpg",
        ],
        [
            "title" => "The Dark Knight - Le Chevalier noir",
            "description" => "Avec l'appui du lieutenant de police Jim Gordon et du procureur de Gotham, Harvey Dent, Batman vise à éradiquer le crime organisé qui pullule dans la ville. Leur association est très efficace, mais elle sera bientôt bouleversée par le chaos déclenché par un criminel psychopathe que les citoyens de Gotham connaissent sous le nom de Joker.",
            "category" => "Action",
            "image" => "images/movies/The_Dark_Knight_Le_Chevalier_noir.jpg",
        ],
        [
            "title" => "Le Bon, la Brute et le Truand",
            "description" => "Un chasseur de primes rejoint deux hommes dans une alliance précaire. Leur but ? Trouver un coffre rempli de pièces d'or dans un cimetière isolé",
            "category" => "Western",
            "image" => "images/movies/Le_Bon_la_Brute_et_le_Truand.jpg",
        ],
        [
            "title" => "Inception",
            "description" => "Dom Cobb est un voleur expérimenté, le meilleur dans l'art dangereux de l'extraction : spécialité qui consiste à voler les secrets les plus intimes enfouis au plus profond du subconscient durant une phase de rêve. Très recherché pour ses talents dans l’univers trouble de l’espionnage industriel, Cobb est aussi devenu un fugitif traqué dans le monde entier. Une ultime mission pourrait lui permettre de retrouver sa vie passée, accomplir une « inception ».",
            "category" => "Action",
            "image" => "images/movies/Inception.jpg",
        ],
        [
            "title" => "Le Seigneur des Anneaux - La Communauté de l'anneau",
            "description" => "Frodon reçoit l'Anneau de son oncle Bilbo. Sa vie et son monde sont pourtant en danger, car cet anneau appartient à Sauron, le maître des ténèbres",
            "category" => "Aventure",
            "image" => "images/movies/Le_Seigneur_des_Anneaux_La_Communaute_de_l_anneau.jpg",
        ],
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
     *
     */
    public function getMoviesInArray()
    {
        $movieRepo = $this->em->getRepository(Movie::class);

        return $movieRepo->findAllInArray();
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

    /**
     * @param $user
     * @param $movieId
     * @param $action
     * @throws \Exception
     */
    public function handleFavourite($user, $movieId, $action)
    {
        if(empty($user)){
            throw new \Exception("You must be logged in to add this movie in favourite");
        }

        if($movieId === "" || $action === ""){
            throw new \Exception("You try to make an impossible action");
        }

        /** @var Movie $movie */
        $movie = $this->em->getRepository(Movie::class)->find($movieId);
        if($movie === null){
            throw new \Exception("The movie you want to {$action} does not exists");
        }

        switch ($action){
            case "add":
                $favourite = new Favourite();
                $favourite->setMovie($movie);
                $favourite->setUser($user);
                $this->em->persist($favourite);
                break;
            case "delete":
                $favouriteRepo = $this->em->getRepository(Favourite::class);
                $favourite = $favouriteRepo->findOneBy([
                    "user" => $user,
                    "movie" => $movie,
                ]);
                $this->em->remove($favourite);
                break;
            default:
                throw new \Exception("Action {$action} is not allow here");
        }

        $this->em->flush();

        return $this->getMoviesInArray();
    }
}