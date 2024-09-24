<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/discipline-supplementaire')]
class FrontendDisciplineSuplementaireController extends AbstractController
{
    #[Route('/', name: 'app_frontend_discipline_supplementaire_choix')]
    public function choix()
    {
        return $this->render('frontend/choix_discipline_supplementaire.html.twig');
    }

    #[Route('/participants', name: 'app_frontend_discipline_supplementaire_participant')]
    public function participant()
    {
        return $this->render('frontend/discipline_supplementaire_participant.html.twig');
    }
}