<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\AllRepositories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{
    public function __construct(
        private AllRepositories $allRepositories
    )
    {
    }

    #[Route('/', name:'app_dashboard')]
    public function index()
    {
//        dd($this->allRepositories->getMembreConneted());
        return $this->render('backend/dashboard.html.twig',[
            'membres' =>$this->allRepositories->getMembreConneted(),
            'abonnements' => $this->allRepositories->getAbonnementStat(),
        ]);
    }
}