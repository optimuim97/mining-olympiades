<?php

namespace App\Controller\Frontend;

use App\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/participation')]
class FrontendParticipationController extends AbstractController
{
    #[Route('/', name: 'app_frontend_participation_non_membre', methods: ['GET'])]
    public function nonmembre()
    {
        return $this->render('frontend/nonmembre.html.twig');
    }

    #[Route('/membre', name: 'app_frontend_participation_add', methods: ['GET'])]
    public function add()
    {
        return $this->render('frontend/participation.html.twig');
    }

}