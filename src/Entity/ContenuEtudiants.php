<?php

namespace App\Entity;

use App\Repository\ContenuEtudiantsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContenuEtudiantsRepository::class)
 */
class ContenuEtudiants
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=DepotsEtudiants::class, inversedBy="contenuEtudiants", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $depot_etudiant_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Fullname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Class;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;
    /**
     * @ORM\Column(type="string")
     */
    private $brochureFilename;

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

    public function getDepotEtudiantId(): ?DepotsEtudiants
    {
        return $this->depot_etudiant_id;
    }

    public function setDepotEtudiantId(DepotsEtudiants $depot_etudiant_id): self
    {
        $this->depot_etudiant_id = $depot_etudiant_id;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->Fullname;
    }

    public function setFullname(string $Fullname): self
    {
        $this->Fullname = $Fullname;

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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }
}
