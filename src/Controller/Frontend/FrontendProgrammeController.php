<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/programme')]
class FrontendProgrammeController extends AbstractController
{
    #[Route('/', name: 'app_frontend_programme_index')]
    public function index()
    {
        return $this->render('frontend/programme.html.twig');
    }
}