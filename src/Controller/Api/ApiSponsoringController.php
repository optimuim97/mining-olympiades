<?php

namespace App\Controller\Api;

use App\Entity\Sponsor;
use App\Repository\SponsorRepository;
use App\Service\GestionMedia;
use App\Service\Utilities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/api/sponsoring')]
class ApiSponsoringController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private GestionMedia $gestionMedia,
        private SponsorRepository $sponsorRepository,
        private Utilities $utilities
    )
    {
    }

    #[Route('/', name: 'app_api_sponsoring_add', methods: ['POST'])]
    public function add(Request $request)
    {
        // vérifions si le sponsor existe déjà
        $slug = (new AsciiSlugger())->slug(strtolower($request->get('compagnie')));
        $verification = $this->sponsorRepository->findOneBy(['slug' => $slug]);
        if ($verification){
            return $this->json([
                'statut' => false,
                'message' => "Vous êtes déjà enregistré"
            ], Response::HTTP_BAD_REQUEST);
        }

        $this->saveSponsoring($request);

        return $this->json([
            'message' => "Votre demande a été envoyée avec succès!"
        ], Response::HTTP_OK);
    }

    private function saveSponsoring(Request $request): void
    {
        $sponsor = new Sponsor();
        $sponsor->setNom(htmlspecialchars($request->get('nom')));
        $sponsor->setPrenoms(htmlspecialchars($request->get('prenoms')));
        $sponsor->setEmail(htmlspecialchars($request->get('email')));
        $sponsor->setFonction(htmlspecialchars($request->get('fonction')));
        $sponsor->setContact(htmlspecialchars($request->get('contact')));
        $sponsor->setEntreprise(htmlspecialchars($request->get('compagnie')));
        $sponsor->setSecteur($this->utilities->secteurSponsor(htmlspecialchars($request->get('secteur'))));
        $sponsor->setSlug((new AsciiSlugger())->slug(strtolower($request->get('compagnie'))));
        $sponsor->setDescription(htmlspecialchars($request->get('description')));
        $sponsor->setOffre(htmlspecialchars($request->get('offre')));

        $this->entityManager->persist($sponsor);
        $this->entityManager->flush();
    }
}