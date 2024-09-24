<?php

namespace App\Controller\Api;

use App\Repository\AbonnementRepository;
use App\Repository\MembreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/abonnement')]
class ApiAbonnementController extends AbstractController
{
    public function __construct(
        private AbonnementRepository $abonnementRepository,
        private MembreRepository $membreRepository,
        private SerializerInterface $serializer
    )
    {
    }

    #[Route('/', name: 'api_abonnement_membre', methods: ['GET'])]
    public function show()
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

        $jsonAbonnement = $this->serializer->serialize($abonnement, 'json',[]);

        return  new JsonResponse($jsonAbonnement, Response::HTTP_OK, [], true);
    }
}