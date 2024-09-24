<?php

namespace App\Controller\Frontend;

use App\Repository\AbonnementRepository;
use App\Repository\JoueurRepository;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/membre')]
class FrontendMembreController extends AbstractController
{
    public function __construct(
        private MembreRepository $membreRepository,
        private AbonnementRepository $abonnementRepository,
        private JoueurRepository $joueurRepository
    )
    {
    }

    #[Route('/', name: 'app_frontend_membre_index')]
    public function index(): Response
    {
        // Vérification de la non existence
        if ($this->verifEtape()){
            return $this->redirectToRoute('app_frontend_membre_participant', [],Response::HTTP_SEE_OTHER);
        }
        return $this->render('frontend/choix_discipline.html.twig');
    }

    #[Route('/participation', name: 'app_frontend_membre_participant')]
    public function participant(): Response
    {
//        dd($this->listeParticipant());
        return $this->render('frontend/membre_participation.html.twig');
    }

    private function verifEtape(): bool
    {
        $membre = $this->membreRepository->findOneBy(['user' =>$this->getUser()->getId() ]);
        if (!$membre) return false;

        $abonnement = $this->abonnementRepository->findOneBy(['compagnie' => $membre->getCompagnie()]);

        if (!$abonnement) return false;

        // S'il n'y a aucun joueur restant rediriger vers la facturaction
//        if ($abonnement->getRestantJoueur() !== 0)

        return true;
    }

    private function listeParticipant()
    {
        $user = $this->getUser();
        $membre = $this->membreRepository->findOneBy(['user' => $user]);
        if (!$membre){
            sweetalert()->addError("Echec, votre compte ne vous autorise pas à choisir des disciplines");
            return $this->json([
                'message' => "Echec, votre compte ne vous autorise pas à choisir des disciplines",
                'statut' => 'Echec'
            ], Response::HTTP_OK);
        }

        return $this->joueurRepository->getJoueurByCompagnie($membre->getCompagnie()); dd($participants);
    }
}