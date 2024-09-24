<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/presentation')]
class FrontendPresentationController extends AbstractController
{
    #[Route('/', name: 'app_frontend_presentation_index', methods: ['GET'])]
    public function index()
    {
        return $this->render('frontend/presentation.html.twig');
    }
}