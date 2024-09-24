<?php

namespace App\Entity;

use App\Repository\CompagnieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompagnieRepository::class)]
class Compagnie implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['participation'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $titre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $dg = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $representant = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'compagnie', targetEntity: Participant::class)]
    #[Groups(['participation'])]
    private Collection $participants;

    #[ORM\OneToMany(mappedBy: 'compagnie', targetEntity: Membre::class)]
    private Collection $membres;

    #[ORM\OneToMany(mappedBy: 'compagnie', targetEntity: Abonnement::class)]
    private Collection $abonnements;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->membres = new ArrayCollection();
        $this->abonnements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDg(): ?string
    {
        return $this->dg;
    }

    public function setDg(?string $dg): static
    {
        $this->dg = $dg;

        return $this;
    }

    public function getRepresentant(): ?string
    {
        return $this->representant;
    }

    public function setRepresentant(?string $representant): static
    {
        $this->representant = $representant;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): static
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
            $participant->setCompagnie($this);
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): static
    {
        if ($this->participants->removeElement($participant)) {
            // set the owning side to null (unless already changed)
            if ($participant->getCompagnie() === $this) {
                $participant->setCompagnie(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'dg' => $this->dg,
            'representant' => $this->representant,
            'contact' => $this->contact,
            'email' => $this->email
        ];
    }

    /**
     * @return Collection<int, Membre>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): static
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->setCompagnie($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): static
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getCompagnie() === $this) {
                $membre->setCompagnie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Abonnement>
     */
    public function getAbonnements(): Collection
    {
        return $this->abonnements;
    }

    public function addAbonnement(Abonnement $abonnement): static
    {
        if (!$this->abonnements->contains($abonnement)) {
            $this->abonnements->add($abonnement);
            $abonnement->setCompagnie($this);
        }

        return $this;
    }

    public function removeAbonnement(Abonnement $abonnement): static
    {
        if ($this->abonnements->removeElement($abonnement)) {
            // set the owning side to null (unless already changed)
            if ($abonnement->getCompagnie() === $this) {
                $abonnement->setCompagnie(null);
            }
        }

        return $this;
    }
}
