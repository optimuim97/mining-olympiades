<?php

namespace App\Controller\Backend;

use App\Entity\Joueur;
use App\Form\JoueurType;
use App\Repository\AbonnementRepository;
use App\Repository\JoueurRepository;
use App\Service\AllRepositories;
use App\Service\GestionMedia;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/joueur')]
class BackendJoueurController extends AbstractController
{
    public function __construct(
        private JoueurRepository $joueurRepository,
        private AllRepositories $allRepositories,
        private AbonnementRepository $abonnementRepository,
        private GestionMedia $gestionMedia
    )
    {
    }

    #[Route('/', name: 'app_backend_joueur_index', methods: ['GET'])]
    public function index(JoueurRepository $joueurRepository): Response
    {
        return $this->render('backend_joueur/index.html.twig', [
            'joueurs' => $joueurRepository->getAll(),
        ]);
    }

    #[Route('/new', name: 'app_backend_joueur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $joueur = new Joueur();
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($joueur);
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_joueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_joueur/new.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_joueur_show', methods: ['GET'])]
    public function show(Joueur $joueur): Response
    {
        return $this->render('backend_joueur/show.html.twig', [
            'participant' => $this->allRepositories->getProfileJoueur($joueur->getId()),
            'joueur' => $this->allRepositories->getProfileJoueur($joueur->getId()),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backend_joueur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Joueur $joueur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JoueurType::class, $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_joueur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_joueur/edit.html.twig', [
            'joueur' => $joueur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_joueur_delete', methods: ['POST'])]
    public function delete(Request $request, Joueur $joueur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$joueur->getId(), $request->request->get('_token'))) {
            $abonnement = $this->abonnementRepository->findOneBy(['id' => $joueur->getAbonnement()]);
            $abonnement->setRestantJoueur((int) $abonnement->getRestantJoueur() + 1);
            $joueur->getDiscipline()->clear();
            $this->gestionMedia->removeUpload($joueur->getMedia(), 'participant');

            $entityManager->remove($joueur);
            $entityManager->flush();

            sweetalert()->addSuccess("Le participant a été supprimé avec succès!");
        }

        return $this->redirectToRoute('app_backend_joueur_index', [], Response::HTTP_SEE_OTHER);
    }
}
