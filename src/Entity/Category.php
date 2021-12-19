<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Rubriques::class, inversedBy="categories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rubrique_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Depots::class, mappedBy="category_id")
     */
    private $depots;

    public function __construct()
    {
        $this->depots = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRubriqueId(): ?Rubriques
    {
        return $this->rubrique_id;
    }

    public function setRubriqueId(?Rubriques $rubrique_id): self
    {
        $this->rubrique_id = $rubrique_id;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Depots[]
     */
    public function getDepots(): Collection
    {
        return $this->depots;
    }

    public function addDepot(Depots $depot): self
    {
        if (!$this->depots->contains($depot)) {
            $this->depots[] = $depot;
            $depot->setCategoryId($this);
        }

        return $this;
    }

    public function removeDepot(Depots $depot): self
    {
        if ($this->depots->removeElement($depot)) {
            // set the owning side to null (unless already changed)
            if ($depot->getCategoryId() === $this) {
                $depot->setCategoryId(null);
            }
        }

        return $this;
    }
    /**
     * Generates the magic method
     * 
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->category;
        // to show the id of the Category in the select
        //return $this->id;
    }
}
