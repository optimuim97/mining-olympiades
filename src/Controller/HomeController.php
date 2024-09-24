<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('frontend/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

//    #[Route('/{slug}', name:'app_frontend_page', methods: ['GET'])]
//    public function page($slug)
//    {
//        return match ($slug){
//            'presentation' => $this->render('frontend/presentation.html.twig'),
//            'programme' => $this->render('frontend/programme.html.twig',['slug'=>null]),
//            'photos' => $this->render('maquette/photo.html.twig'),
//            'contact' => $this->render('maquette/contact.html.twig'),
//            'webtv' => $this->render('frontend/webtv.html.twig'),
//            'participation' => $this->render('maquette/participation.html.twig'),
//            'participant' => $this->render('maquette/participant.html.twig'),
//            default => $this->redirectToRoute('app_maquette_accueil')
//        };
//    }
}
