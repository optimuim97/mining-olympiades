<?php

namespace App\Controller\Api;

use App\Entity\Telechargeur;
use App\Repository\TelechargeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/api/telechargeur')]
class ApiTelechargeurController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private TelechargeurRepository $telechargeurRepository
    )
    {
    }

    #[Route('/', name: 'api_telechargeur_add', methods: ['POST'])]
    public function add(Request $request)
    {
        $this->saveTelechargeur($request);

        return $this->json([
            "statut" => true
        ], Response::HTTP_OK);
    }

    private function saveTelechargeur(Request $request): void
    {
        $new = new Telechargeur();
        $new->setNom(htmlspecialchars($request->get('nom')));
        $new->setPrenoms(htmlspecialchars($request->get('prenoms')));
        $new->setContact(htmlspecialchars($request->get('contact')));
        $new->setEmail(htmlspecialchars($request->get('email')));
        $new->setEntreprise(htmlspecialchars($request->get('compagnie')));
        $new->setFonction(htmlspecialchars($request->get('fonction')));
        $new->setSecteur(htmlspecialchars($request->get('secteur')));
        $new->setDescription(htmlspecialchars($request->get('description')));
        $new->setSlug((new AsciiSlugger())->slug($request->get('nom').'-'.$request->get('prenoms')));

        $this->entityManager->persist($new);
        $this->entityManager->flush();
    }
}