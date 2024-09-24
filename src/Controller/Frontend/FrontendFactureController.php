<?php

namespace App\Controller\Frontend;

use App\Repository\AbonnementRepository;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/facture')]
class FrontendFactureController extends AbstractController
{
    public function __construct(
        private AbonnementRepository $abonnementRepository,
        private MembreRepository $membreRepository
    )
    {
    }

    #[Route('/', name: 'app_frontend_facture_show')]
    public function show()
    {
        return $this->render('frontend/facture.html.twig');
    }

}