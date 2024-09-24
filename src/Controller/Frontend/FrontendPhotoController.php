<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/galerie')]
class FrontendPhotoController extends AbstractController
{
    #[Route('/', name: 'app_frontend_photo_index')]
    public function index()
    {
        return $this->render('frontend/galerie.html.twig');
    }
}