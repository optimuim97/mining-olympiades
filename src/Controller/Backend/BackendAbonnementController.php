<?php

namespace App\Controller\Backend;

use App\Entity\Abonnement;
use App\Form\AbonnementType;
use App\Repository\AbonnementRepository;
use App\Repository\JoueurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/abonnement')]
class BackendAbonnementController extends AbstractController
{
    public function __construct(
        private JoueurRepository $joueurRepository)
    {
    }

    #[Route('/', name: 'app_backend_abonnement_index', methods: ['GET'])]
    public function index(AbonnementRepository $abonnementRepository): Response
    {
        return $this->render('backend_abonnement/index.html.twig', [
            'abonnements' => $abonnementRepository->getRealAbonnement(),
        ]);
    }

    #[Route('/new', name: 'app_backend_abonnement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $abonnement = new Abonnement();
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($abonnement);
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_abonnement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_abonnement/new.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_abonnement_show', methods: ['GET'])]
    public function show(Abonnement $abonnement): Response
    {
        return $this->render('backend_abonnement/show.html.twig', [
            'joueurs' => $this->joueurRepository->getJoueursByAbonnement($abonnement->getId()),
            'abonnement' => $abonnement
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backend_abonnement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Abonnement $abonnement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AbonnementType::class, $abonnement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_abonnement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_abonnement/edit.html.twig', [
            'abonnement' => $abonnement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_abonnement_delete', methods: ['POST'])]
    public function delete(Request $request, Abonnement $abonnement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abonnement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($abonnement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backend_abonnement_index', [], Response::HTTP_SEE_OTHER);
    }
}
