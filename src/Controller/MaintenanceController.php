<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/maintenance')]
class MaintenanceController extends AbstractController
{
    #[Route('/', name: 'app_maintenance_index')]
    public function index(): Response
    {
        return $this->render('maintenance/index.html.twig', [
            'controller_name' => 'MaintenanceController',
        ]);
    }
}
