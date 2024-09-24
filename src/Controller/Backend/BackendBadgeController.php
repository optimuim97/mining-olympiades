<?php

namespace App\Controller\Backend;

use App\Entity\Compagnie;
use App\Repository\JoueurRepository;
use App\Repository\MembreRepository;
use App\Service\AllRepositories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/print')]
class BackendBadgeController extends AbstractController
{
    public function __construct(
        private JoueurRepository $joueurRepository,
        private AllRepositories $allRepositories,
    )
    {
    }

    #[Route('/', name: 'app_backend_badge_liste')]
    public function liste()
    {
        $joueurs = $this->joueurRepository->findAll();
        $participants=[];
        foreach ($joueurs as $joueur){
            $participants[] = $this->allRepositories->getProfileJoueur($joueur->getId());
        }

//        dd($participants);
        return $this->render('backend/badges.html.twig',[
            'joueurs' =>$participants
        ]);
    }

    #[Route('/{id}/', name: 'app_backend_badge_compagnie', methods: ['GET'])]
    public function badge(Request $request, Compagnie $compagnie)
    {
        $joueurs = $this->joueurRepository->getJoueurByCompagnie($compagnie);

        $nombre = count($joueurs);

        $flag = (int) $request->get('flag');
        $fin = $flag;
        if ($flag < 1) {
            $fin = 1;
        }

//        $limit = 1;
        $limit = $fin * 10;
//        $debut = 0;
        $debut = $limit - 10;

        if ($nombre > $limit) {
            if ($flag < 1) {
                $flag = 2;
            }else{
                $flag += 1;
            }

        }

//        dd($flag);

        $joueurs = array_slice($joueurs, $debut, $limit);

        $participants=[];
        foreach ($joueurs as $joueur){

            $participants[] = $this->allRepositories->getProfileJoueur($joueur->getId());
        }

        return $this->render('backend/badges.html.twig',[
            'joueurs' =>$participants,
            'flag' => $flag
        ]);
    }

    #[Route('/equipes/liste', name: 'app_backend_badge_equipe')]
    public function equipe()
    {
        return $this->render('backend/badge_equipe.html.twig',[
            'compagnies' => $this->allRepositories->getAllCompagnieWithParticipant(),
        ]);
    }
}