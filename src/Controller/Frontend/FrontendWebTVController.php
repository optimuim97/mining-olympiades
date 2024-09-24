<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/webtv')]
class FrontendWebTVController extends AbstractController
{
    #[Route('/', name: 'app_frontendwebtv_list')]
    public function list()
    {
        return $this->render('frontend/webtv.html.twig',[
            'slug' => null
        ]);
    }
    #[Route('/{slug}', name: 'app_frontendwebtv_show', methods: ['GET'])]
    public function show($slug)
    {
        return $this->render('frontend/webtv.html.twig',[
            'slug' => $slug
        ]);
    }
}