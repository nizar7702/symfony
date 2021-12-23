<?php

namespace App\Entity;

use App\Repository\ContenuDepotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContenuDepotRepository::class)
 */
class ContenuDepot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Depots::class, inversedBy="contenuDepot", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $depot_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $description;
    /**
     * @ORM\Column(type="string")
     */
    private $brochureFilename;

    /**
     * @ORM\OneToMany(targetEntity=DepotsEtudiants::class, mappedBy="contenu_depot_id")
     */
    private $depotsEtudiants;

    /**
     * @ORM\OneToMany(targetEntity=Likes::class, mappedBy="contenu_depot_id")
     */
    private $likes;



    public function __construct()
    {
        $this->depotsEtudiants = new ArrayCollection();
        $this->Fullname = new ArrayCollection();
        $this->user_id = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }

    public function getBrochureFilename()
    {
        return $this->brochureFilename;
    }

    public function setBrochureFilename($brochureFilename)
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepotId(): ?Depots
    {
        return $this->depot_id;
    }

    public function setDepotId(Depots $depot_id): self
    {
        $this->depot_id = $depot_id;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|DepotsEtudiants[]
     */
    public function getDepotsEtudiants(): Collection
    {
        return $this->depotsEtudiants;
    }

    public function addDepotsEtudiant(DepotsEtudiants $depotsEtudiant): self
    {
        if (!$this->depotsEtudiants->contains($depotsEtudiant)) {
            $this->depotsEtudiants[] = $depotsEtudiant;
            $depotsEtudiant->setContenuDepotId($this);
        }

        return $this;
    }

    public function removeDepotsEtudiant(DepotsEtudiants $depotsEtudiant): self
    {
        if ($this->depotsEtudiants->removeElement($depotsEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($depotsEtudiant->getContenuDepotId() === $this) {
                $depotsEtudiant->setContenuDepotId(null);
            }
        }

        return $this;
    }
    public function __toString(){
        // to show the name of the Category in the select
        return $this->title;
        // to show the id of the Category in the select
        //return $this->id;
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
