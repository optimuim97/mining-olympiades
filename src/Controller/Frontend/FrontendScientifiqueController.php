<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/journee-scientifique')]
class FrontendScientifiqueController extends AbstractController
{
    #[ROute('/', name: 'app_frontend_journee_scientifique_index')]
    public function index()
    {
        return $this->render('frontend/journee_scientifique_index.html.twig');
    }
}