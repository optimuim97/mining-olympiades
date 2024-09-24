<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class FrontendContactController extends AbstractController
{
    #[Route('/', name: 'app_frontend_contact_index')]
    public function index()
    {
        return $this->render('frontend/contact.html.twig');
    }
}