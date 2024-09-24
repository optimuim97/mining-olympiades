<?php

namespace App\Service;

use App\Repository\AbonnementRepository;
use App\Repository\CompagnieRepository;
use App\Repository\DisciplineRepository;
use App\Repository\JoueurRepository;
use App\Repository\MembreRepository;
use App\Repository\ParticipantRepository;
use App\Repository\UserRepository;
use http\Exception\InvalidArgumentException;
use Symfony\Component\String\Slugger\AsciiSlugger;

class AllRepositories
{
    public function __construct(
        private UserRepository $userRepository,
        private DisciplineRepository $disciplineRepository,
        private CompagnieRepository $compagnieRepository,
        private ParticipantRepository $participantRepository,
        private JoueurRepository $joueurRepository,
        private MembreRepository $membreRepository,
        private AbonnementRepository $abonnementRepository
    )
    {
    }

    public function generateLicence(): string
    {
        do{
            $lettre_aleatoire = chr(random_int(0,25) + ord('A'));
            $nombre_aleatoire = random_int(10000,99999);

            $licence = date('y').'-'.$nombre_aleatoire.' '.$lettre_aleatoire;

            $verifLicence = $this->joueurRepository->findOneBy(['licence' => $licence]);

        } while($verifLicence);

        return $licence;

    }

    public function getUsers(string $email ): array
    {
        if (empty($email)){
            throw new InvalidArgumentException("Le nom utilisateur ne peut être vide");
        }

        try {
            $getUsers = $this->userRepository->findWithout($email);
        } catch (\Exception $e){
            error_log("Erreur lors de la récupération des utilisateurs : " .$e->getMessage());
            return [];
        }

        return array_map(static function ($getUser) {
            $roleMapping = [
                'ROLE_ADMIN' => "Administrateur",
                'ROLE_COORDINATEUR' => "Coordinateur",
                'ROLE_USER' => "Utilisateur"
            ];
            $roles = $getUser->getRoles()[0] ?? $getUser->getRoles();
            $role = $roleMapping[$roles] ?? 'Utilisateur';

            return [
                'id' => $getUser->getId(),
                'userIdentifier' => $getUser->getUserIdentifier(),
                'role' => $role,
                'connexion' => $getUser->getConnexion(),
                'lastConnectedAt' => $getUser->getLastConnectedAt()
            ];
        }, $getUsers);

    }

    public function slug($entity): void
    {
        $entity->setSlug((new AsciiSlugger())->slug(strtolower($entity->getTitre())));
    }

    public function getAllDiscipline(): array
    {
        return $this->disciplineRepository->findBy([],['titre' => 'ASC']);
    }

    public function getAllCompagnie()
    {
        return $this->compagnieRepository->findBy([],['titre' => "ASC"]);
    }

    public function getUniqueParticipant($slug)
    {
        return $this->participantRepository->findOneBy(['slug' => $slug]);
    }

    public function getProfileJoueur($joueurId)
    {
        $joueur = $this->joueurRepository->getOneById($joueurId);

        $jeu = '';
        foreach ($joueur->getDiscipline() as $discipline){
            $jeu = $discipline->getTitre();
        }

        return [
            'id' => $joueur->getId(),
            'nom' => $joueur->getNom(),
            'prenoms' => $joueur->getPrenoms(),
            'matricule' => $joueur->getMatricule(),
            'licence' => $joueur->getLicence(),
            'entreprise' => $joueur->getAbonnement()->getCompagnie()->getTitre(),
            'email' => $joueur->getEmail(),
            'contact' => $joueur->getContact(),
            'discipline' => $jeu,
            'slug' => $joueur->getSlug(),
            'media' => $joueur->getMedia(),
            'carte' => $joueur->getCarte()
        ];
    }

    public function getAllCompagnieWithParticipant()
    {
        $compagnies = $this->getAllCompagnie();

        $entreprise = [];
        foreach ($compagnies as $compagny){
            $abonnements = $compagny->getAbonnements();
            $abonnement = [];
            foreach ($abonnements as $abonnement){
                $abonnement = $abonnement;
            }

            $entreprise [] =[
                'id' => $compagny->getId(),
                'slug' => $compagny->getSlug(),
                'titre' => $compagny->getTitre(),
                'nom' => $compagny->getTitre(),
                'dg' => $compagny->getDg(),
                'representant' => $compagny->getRepresentant(),
                'contact' => $compagny->getContact(),
                'email' => $compagny->getEmail(),
                'participant' => count($this->joueurRepository->getJoueurByCompagnie($compagny->getId())),
                'abonnement' => $abonnement
            ];
        }

        return $entreprise;
    }

    public function getOneCompagnieWithParticipants(?int $getId)
    {
        $compagny = $this->compagnieRepository->findOneBy(['id' => $getId]);

        $abonnement = [];
        foreach ($compagny->getAbonnements() as $abonnement){
            $abonnement = $abonnement;
        }

        return [
            'id' => $compagny->getId(),
            'slug' => $compagny->getSlug(),
            'titre' => $compagny->getTitre(),
            'nom' => $compagny->getTitre(),
            'dg' => $compagny->getDg(),
            'representant' => $compagny->getRepresentant(),
            'contact' => $compagny->getContact(),
            'email' => $compagny->getEmail(),
            'participant' => count($this->joueurRepository->getJoueurByCompagnie($compagny->getId())),
            'participants' => $this->joueurRepository->getJoueurByCompagnie($compagny->getId()),
            'abonnement' => $abonnement,
        ];

    }

    public function getMembreConneted()
    {
        return $this->membreRepository->getMonitoring();
    }

    public function getAbonnementStat()
    {
        $abonnements = $this->abonnementRepository->getAbonnementWithCompagnie();
        $total = $this->abonnementRepository->getTotalJoueur() ?? 1;
        $tableau=[]; $i=0;
        foreach ($abonnements as $abonnement){
            $pourcentage = round(((int) $abonnement->getTotalJoueur() * 100 / $total), 1);
            $tableau[$i++]=[
                'id' => $abonnement->getId(),
                'reference' => $abonnement->getReference(),
                'montant' => $abonnement->getmontant(),
                'compagnie' => $abonnement->getcompagnie(),
                'totalJoueur' => $abonnement->getTotalJoueur(),
                'restantJoueur' => $abonnement->getRestantJoueur(),
                'pourcentage' => $pourcentage,
            ];
        }

        return $tableau;
    }
}