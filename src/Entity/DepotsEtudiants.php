<?php

namespace App\Entity;

use App\Repository\DepotsEtudiantsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepotsEtudiantsRepository::class)
 */
class DepotsEtudiants
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ContenuDepot::class, inversedBy="depotsEtudiants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $contenu_depot_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $FullName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Class;

    /**
     * @ORM\OneToOne(targetEntity=ContenuEtudiants::class, mappedBy="depot_etudiant_id", cascade={"persist", "remove"})
     */
    private $contenuEtudiants;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenuDepotId(): ?ContenuDepot
    {
        return $this->contenu_depot_id;
    }

    public function setContenuDepotId(?ContenuDepot $contenu_depot_id): self
    {
        $this->contenu_depot_id = $contenu_depot_id;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->FullName;
    }

    public function setFullName(string $FullName): self
    {
        $this->FullName = $FullName;

        return $this;
    }

    public function getClass(): ?string
    {
        return $this->Class;
    }

    public function setClass(string $Class): self
    {
        $this->Class = $Class;

        return $this;
    }

    public function getContenuEtudiants(): ?ContenuEtudiants
    {
        return $this->contenuEtudiants;
    }

    public function setContenuEtudiants(ContenuEtudiants $contenuEtudiants): self
    {
        // set the owning side of the relation if necessary
        if ($contenuEtudiants->getDepotEtudiantId() !== $this) {
            $contenuEtudiants->setDepotEtudiantId($this);
        }

        $this->contenuEtudiants = $contenuEtudiants;

        return $this;
    }
}
