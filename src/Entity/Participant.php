<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant implements \JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['participation'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $prenoms = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $matricule = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $media = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['participation'])]
    private ?string $licence = null;

    #[ORM\ManyToOne(inversedBy: 'participants')]
    #[Groups(['participation'])]
    private ?Compagnie $compagnie = null;

    #[ORM\OneToMany(mappedBy: 'participant', targetEntity: Competir::class)]
    #[Groups(['participation'])]
    private Collection $competirs;

    public function __construct()
    {
        $this->competirs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenoms(): ?string
    {
        return $this->prenoms;
    }

    public function setPrenoms(?string $prenoms): static
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(?string $matricule): static
    {
        $this->matricule = $matricule;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getLicence(): ?string
    {
        return $this->licence;
    }

    public function setLicence(?string $licence): static
    {
        $this->licence = $licence;

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
            $competir->setParticipant($this);
        }

        return $this;
    }

    public function removeCompetir(Competir $competir): static
    {
        if ($this->competirs->removeElement($competir)) {
            // set the owning side to null (unless already changed)
            if ($competir->getParticipant() === $this) {
                $competir->setParticipant(null);
            }
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        return  [
            'id' => $this->id,
            'nom' => $this->nom,
            'prenoms' => $this->prenoms,
            'matricule' => $this->matricule,
            'contact' => $this->contact,
            'licence' => $this->licence,
            'email' => $this->email,
            'media' => $this->media
        ];
    }
}
