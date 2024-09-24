<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnementRepository::class)]
class Abonnement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(nullable: true)]
    private ?int $annee = null;

    #[ORM\Column(nullable: true)]
    private ?int $montant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $media = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $justificatif = null;

    #[ORM\ManyToOne(inversedBy: 'abonnements')]
    private ?Compagnie $compagnie = null;

    #[ORM\ManyToMany(targetEntity: Discipline::class, inversedBy: 'abonnements')]
    private Collection $disciplines;

    #[ORM\Column(nullable: true)]
    private ?bool $solde = null;

    #[ORM\OneToMany(mappedBy: 'abonnement', targetEntity: Joueur::class)]
    private Collection $joueurs;

    #[ORM\Column(nullable: true)]
    private ?int $totalJoueur = null;

    #[ORM\Column(nullable: true)]
    private ?int $restantJoueur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    public function __construct()
    {
        $this->disciplines = new ArrayCollection();
        $this->joueurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(?int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(?int $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getMedia(): ?string
    {
        return $this->media;
    }

    public function setMedia(?string $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getJustificatif(): ?string
    {
        return $this->justificatif;
    }

    public function setJustificatif(?string $justificatif): static
    {
        $this->justificatif = $justificatif;

        return $this;
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

    /**
     * @return Collection<int, Discipline>
     */
    public function getDisciplines(): Collection
    {
        return $this->disciplines;
    }

    public function addDiscipline(Discipline $discipline): static
    {
        if (!$this->disciplines->contains($discipline)) {
            $this->disciplines->add($discipline);
        }

        return $this;
    }

    public function removeDiscipline(Discipline $discipline): static
    {
        $this->disciplines->removeElement($discipline);

        return $this;
    }

    public function isSolde(): ?bool
    {
        return $this->solde;
    }

    public function setSolde(?bool $solde): static
    {
        $this->solde = $solde;

        return $this;
    }

    /**
     * @return Collection<int, Joueur>
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueur $joueur): static
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs->add($joueur);
            $joueur->setAbonnement($this);
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): static
    {
        if ($this->joueurs->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getAbonnement() === $this) {
                $joueur->setAbonnement(null);
            }
        }

        return $this;
    }

    public function getTotalJoueur(): ?int
    {
        return $this->totalJoueur;
    }

    public function setTotalJoueur(?int $totalJoueur): static
    {
        $this->totalJoueur = $totalJoueur;

        return $this;
    }

    public function getRestantJoueur(): ?int
    {
        return $this->restantJoueur;
    }

    public function setRestantJoueur(?int $restantJoueur): static
    {
        $this->restantJoueur = $restantJoueur;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
