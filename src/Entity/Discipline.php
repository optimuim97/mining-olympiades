<?php

namespace App\Entity;

use App\Repository\DisciplineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DisciplineRepository::class)]
class Discipline implements \JsonSerializable
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
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'discipline', targetEntity: Competir::class)]
    #[Groups(['participation'])]
    private Collection $competirs;

    #[ORM\Column(nullable: true)]
    private ?int $joueur = null;

    #[ORM\ManyToMany(targetEntity: Abonnement::class, mappedBy: 'disciplines')]
    private Collection $abonnements;

    #[ORM\ManyToMany(targetEntity: Joueur::class, mappedBy: 'discipline')]
    private Collection $joueurs;

    #[ORM\Column(nullable: true, options: (['default' => true]))]
    private ?bool $Complementaire = null;

    public function __construct()
    {
        $this->competirs = new ArrayCollection();
        $this->abonnements = new ArrayCollection();
        $this->joueurs = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Competir>
     */
    public function getCompetirs(): Collection
    {
        return $this->competirs;
    }

    public function addCompetir(Competir $competir): static
    {
        if (!$this->competirs->contains($competir)) {
            $this->competirs->add($competir);
            $competir->setDiscipline($this);
        }

        return $this;
    }

    public function removeCompetir(Competir $competir): static
    {
        if ($this->competirs->removeElement($competir)) {
            // set the owning side to null (unless already changed)
            if ($competir->getDiscipline() === $this) {
                $competir->setDiscipline(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'joueur' => $this->joueur,
            'slug' => $this->slug,
        ];
    }

    public function getJoueur(): ?int
    {
        return $this->joueur;
    }

    public function setJoueur(?int $joueur): static
    {
        $this->joueur = $joueur;

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
            $abonnement->addDiscipline($this);
        }

        return $this;
    }

    public function removeAbonnement(Abonnement $abonnement): static
    {
        if ($this->abonnements->removeElement($abonnement)) {
            $abonnement->removeDiscipline($this);
        }

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
            $joueur->addDiscipline($this);
        }

        return $this;
    }

    public function removeJoueur(Joueur $joueur): static
    {
        if ($this->joueurs->removeElement($joueur)) {
            $joueur->removeDiscipline($this);
        }

        return $this;
    }

    public function isComplementaire(): ?bool
    {
        return $this->Complementaire;
    }

    public function setComplementaire(?bool $Complementaire): static
    {
        $this->Complementaire = $Complementaire;

        return $this;
    }
}
