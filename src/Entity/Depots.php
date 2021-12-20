<?php

namespace App\Entity;

use App\Repository\DepotsRepository;
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
     * @ORM\JoinColumn(nullable=false)
     */
    private $category_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\OneToOne(targetEntity=ContenuDepot::class, mappedBy="depot_id", cascade={"persist", "remove"})
     */
    private $contenuDepot;

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
}
