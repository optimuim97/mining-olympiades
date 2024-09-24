<?php

namespace App\Service;

use App\Entity\Sponsor;
use App\Repository\SponsorRepository;
use Doctrine\ORM\EntityManagerInterface;

class Utilities
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SponsorRepository $sponsorRepository
    )
    {
    }

    public function secteurSponsor(string $string)
    {
        return match ($string){
            'production' => "Production minière",
            'construction' => "Construct",
            'recherche' => "Recherche minière",
            'sous-traitant' => "Sous traitant",
            'fournisseur' => "Fournisseur de service",
            'geo-service' => "Geo service",
        default => "Autre"
        };
    }

    public function validationSponsoring(Sponsor $sponsor): void
    {
        $sponsor->setStatut(true);

        $this->entityManager->flush();
    }
}