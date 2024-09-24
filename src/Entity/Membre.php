<?php

namespace App\Entity;

use App\Repository\MembreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembreRepository::class)]
class Membre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    private ?Compagnie $compagnie = null;

    #[ORM\ManyToOne(inversedBy: 'membres')]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?int $participation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompagnie(): ?Compagnie
    {
        return $this->compagnie;
    }

    public function setCompagnie(?Compagnie $compagnie): static
    {
        $this->compagnie = $compagnie;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getParticipation(): ?int
    {
        return $this->participation;
    }

    public function setParticipation(?int $participation): static
    {
        $this->participation = $participation;

        return $this;
    }
}
