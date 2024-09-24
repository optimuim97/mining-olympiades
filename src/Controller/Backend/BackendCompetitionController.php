<?php

namespace App\Controller\Backend;

use App\Entity\Discipline;
use App\Repository\AbonnementRepository;
use App\Repository\DisciplineRepository;
use App\Repository\JoueurRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/competition')]
class BackendCompetitionController extends AbstractController
{
    public function __construct(
        private DisciplineRepository $disciplineRepository,
        private JoueurRepository $joueurRepository,
        private AbonnementRepository $abonnementRepository
    )
    {
    }

    #[Route('/', name: 'app_backend_competition_index')]
    public function index()
    {
        //dd($this->abonnementRepository->findAll());
        $disciplines = $this->disciplineRepository->findAll();

        $liste= []; $nombre=0;

        foreach ($disciplines as $discipline){
            $nombre = $this->joueurRepository->getJoueursByDisciplineGroupByAbonnement($discipline);
            if (count($nombre) > 0){
                $liste[] = $discipline;
            }
        }

        return $this->render('backend_competition/index.html.twig',[
            'disciplines' => $liste
        ]);
    }

    #[Route('/{discipline}', name: 'app_backend_competition_discipline', methods: ['GET'])]
    public function equipe(Discipline $discipline)
    {
        return $this->render('backend_competition/discipline.html.twig', [
            'discipline' => $discipline
        ]);
    }
}