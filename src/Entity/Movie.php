<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="Favourite", mappedBy="movie")
     */
    private $favourites;

    /**
     *
     */
    public function __construct() {
        $this->favourites = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     * @return $this
     */
    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCategory(): ?string
    {
        return $this->category;
    }

    /**
     * @param string|null $category
     * @return $this
     */
    public function setCategory(?string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getFavourites(): ArrayCollection
    {
        return $this->favourites;
    }

    /**
     * @param Favourite $favourite
     * @return Movie
     */
    public function addFavourite(Favourite $favourite): Movie
    {
        if($this->favourites->contains($favourite) === false){
            $this->favourites[] = $favourite;
        }

        return $this;
    }

    /**
     * @param Favourite $favourite
     * @return Movie
     */
    public function removeFavourite(Favourite $favourite): Movie
    {
        if($this->favourites->contains($favourite)){
            $this->favourites->remove($favourite);
        }

        return $this;
    }
}
