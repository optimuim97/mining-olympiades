<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/maquette')]
class MaquetteController extends AbstractController
{
    #[Route('/', name: 'app_maquette_accueil')]
    public function accueil()
    {
        return $this->render('maquette/accueil.html.twig');
    }

    #[Route('/{slug}', name: 'app_maquette_page')]
    public function page($slug)
    {
        return match ($slug){
            'presentation' => $this->render('maquette/presentation.html.twig'),
            'programme' => $this->render('maquette/programme.html.twig'),
            'photos' => $this->render('maquette/photo.html.twig'),
            'contact' => $this->render('maquette/contact.html.twig'),
            'webtv' => $this->render('maquette/webtv.html.twig'),
            'participation' => $this->render('maquette/participation.html.twig'),
            'participant' => $this->render('maquette/participant.html.twig'),
            default => $this->redirectToRoute('app_maquette_accueil')
        };
    }
}