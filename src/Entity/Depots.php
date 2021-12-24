<?php

namespace App\Entity;

use App\Repository\DepotsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepotsRepository::class)
 */
class Depots
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="depots")
     * @ORM\JoinColumn(nullable=false,)
     */
    private $category_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToOne(targetEntity=ContenuDepot::class, mappedBy="depot_id", cascade={"persist","remove"})
     */
    private $contenuDepot;

    /**
     * @ORM\Column(type="float")
     */
    private $NbLikes;

    /**
     * @ORM\OneToMany(targetEntity=Likes::class, mappedBy="contenu_depot_id",cascade={"remove"})
     */
    private $likes;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategoryId(): ?Category
    {
        return $this->category_id;
    }

    public function setCategoryId(?Category $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContenuDepot(): ?ContenuDepot
    {
        return $this->contenuDepot;
    }

    public function setContenuDepot(ContenuDepot $contenuDepot): self
    {
        // set the owning side of the relation if necessary
        if ($contenuDepot->getDepotId() !== $this) {
            $contenuDepot->setDepotId($this);
        }

        $this->contenuDepot = $contenuDepot;

        return $this;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->title;
        // to show the id of the Category in the select
        //return $this->id;
    }

    public function getNbLikes(): ?float
    {
        return $this->NbLikes;
    }

    public function setNbLikes(float $NbLikes): self
    {
        $this->NbLikes = $NbLikes;

        return $this;
    }

    /**
     * @return Collection|Likes[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Likes $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setContenuDepotId($this);
        }

        return $this;
    }

    public function removeLike(Likes $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getContenuDepotId() === $this) {
                $like->setContenuDepotId(null);
            }
        }

        return $this;
    }
}
