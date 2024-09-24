<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sponsoring')]
class FrontendSponsorController extends AbstractController
{
    #[Route('/', name:'app_frontend_sponsoring_index')]
    public function index()
    {
        return $this->render('frontend/sponsoring.html.twig',[
            'titre' => "S'associer à l'évènement en tant que sponsor"
        ]);
    }

    #[Route('/telecharger', name:'app_frontend_telecharger')]
    public function telecharger()
    {
        return $this->render('frontend/telechargeur.html.twig',[
            'titre' => "Télécharger la plaquette de présentation"
        ]);
    }

    #[Route('/telechargement/plaquette', name: 'app_frontend_telechargement')]
    public function telechargement()
    {
        return $this->render('frontend/telechargement.html.twig',[]);
    }
}