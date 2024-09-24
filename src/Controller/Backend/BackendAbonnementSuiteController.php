<?php

namespace App\Controller\Backend;

use App\Repository\AbonnementRepository;
use App\Repository\DisciplineRepository;
use App\Repository\JoueurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/abonnement-suite')]
class BackendAbonnementSuiteController extends AbstractController
{
    public function __construct(
        private JoueurRepository $joueurRepository, private AbonnementRepository $abonnementRepository,
        private DisciplineRepository $disciplineRepository
    )
    {
    }

    #[Route('/{id}/{discipline}', name: 'backend_abonnement_suite_details', methods: ['GET'])]
    public function details($id, $discipline)
    {
        return $this->render('backend_abonnement/details.html.twig', [
            'joueurs' => $this->joueurRepository->getNombreJoueurByAbonnementAndDiscipline($discipline, $id),
            'abonnement' => $this->abonnementRepository->findOneBy(['id' => $id]),
            'discipline' => $this->disciplineRepository->findOneBy(['id' => $discipline])
        ]);
    }
}