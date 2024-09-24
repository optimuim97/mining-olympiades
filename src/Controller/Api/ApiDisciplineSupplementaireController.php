<?php

namespace App\Controller\Api;

use App\Repository\AbonnementRepository;
use App\Repository\DisciplineRepository;
use App\Repository\MembreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/discipline-supplementaire')]
class ApiDisciplineSupplementaireController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer,
        private AbonnementRepository $abonnementRepository,
        private MembreRepository $membreRepository,
        private DisciplineRepository $disciplineRepository
    )
    {
    }

    #[Route('/', name: 'api_discipline_supplementaire_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $user = $this->getUser();
        $membre = $this->membreRepository->findOneBy(['user' => $user]);
        if (!$membre){
            sweetalert()->addError("Echec, votre compte ne vous autorise pas à choisir des disciplines");
            return $this->json([
                'message' => "Echec, votre compte ne vous autorise pas à choisir des disciplines",
                'statut' => 'Echec'
            ], Response::HTTP_OK);
        }

        $abonnement = $this->abonnementRepository->findOneBy(['compagnie' => $membre->getCompagnie()],['id' => "DESC"]);

        $disciplines = $this->disciplineRepository->getListeExclues();

        $disciplineChoisies=[];
        foreach ($abonnement->getDisciplines() as $discipline){
            $disciplineChoisies[] = $discipline;
        }

        $disciplineConcernees = array_udiff($disciplines, $disciplineChoisies, function ($a, $b){
            return $a->getId() - $b->getId();
        });

        $jsonDiscipline = $this->serializer->serialize($disciplines, 'json', ['groups' => 'participation']);

        return new JsonResponse($jsonDiscipline, Response::HTTP_OK, [], true);
    }

    #[Route('/abonnement', name: 'api_discipline_supplementaire_abonnement', methods: ['POST'])]
    public function abonnement(Request $request)
    {
        $datas = json_decode($request->getContent(), true);
        if (!$datas || empty($datas['disciplines'])){
            return $this->json([
                'message' => "Echec, veuillez choisir les disciplines supplémentaires",
                'statut' => "nonDiscipline"
            ]);
        }

        // Utilisateur, vérification du membre
        $membre = $this->membreRepository->findOneBy(['user' => $this->getUser()]);
        if (!$membre){
            return $this->json([
                'message' => "Echèc, votre compte ne vous autorise pas à choisir des disciplines",
                'statut' => "nonAutorise"
            ]);
        }

        $abonnement = $this->abonnementRepository->findOneBy(['compagnie' => $membre->getCompagnie()],['id'=>"DESC"]);
        if (!$abonnement){
            return;
        }

        $abonnement->setMontant( (int)$abonnement->getMontant() + 250000);
        $abonnement->setRestantJoueur((int) $abonnement->getRestantJoueur() + (int) $datas['totalJoueurs']);
        $abonnement->setTotalJoueur((int) $abonnement->getTotalJoueur() + (int) $datas['totalJoueurs']);
        $abonnement->setCreatedAt(new \DateTime());

        foreach ($datas['disciplines'] as $data){
            $discipline = $this->disciplineRepository->findOneBy(['id'=> $data]);
            if ($discipline) $abonnement->addDiscipline($discipline);
        }

        $this->entityManager->flush();

        return $this->json([
            'message' => "Vos disciplines ont été sauvegardées avec succès!",
            'statut' => "success"
        ]);
    }

}