<?php

namespace App\Entity;

use App\Repository\LikesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikesRepository::class)
 */
class Likes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="likes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=Depots::class, inversedBy="likes")
     */
    private $contenu_depot_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getContenuDepotId(): ?Depots
    {
        return $this->contenu_depot_id;
    }

    public function setContenuDepotId(?Depots $contenu_depot_id): self
    {
        $this->contenu_depot_id = $contenu_depot_id;

        return $this;
    }
}
