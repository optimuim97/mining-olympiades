<?php

namespace App\Entity;

use App\Repository\CompetirRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CompetirRepository::class)]
class Competir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['participation'])]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['participation'])]
    private ?int $annee = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['participation'])]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'competirs')]
    #[Groups(['participation'])]
    private ?Participant $participant = null;

    #[ORM\ManyToOne(inversedBy: 'competirs')]
    #[Groups(['participation'])]
    private ?Discipline $discipline = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getParticipant(): ?Participant
    {
        return $this->participant;
    }

    public function setParticipant(?Participant $participant): static
    {
        $this->participant = $participant;

        return $this;
    }

    public function getDiscipline(): ?Discipline
    {
        return $this->discipline;
    }

    public function setDiscipline(?Discipline $discipline): static
    {
        $this->discipline = $discipline;

        return $this;
    }
}
