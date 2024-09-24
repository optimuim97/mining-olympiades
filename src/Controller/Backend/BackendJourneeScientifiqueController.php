<?php

namespace App\Controller\Backend;

use App\Entity\Etudiant;
use App\Form\EtudiantType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/journee/scientifique')]
class BackendJourneeScientifiqueController extends AbstractController
{
    #[Route('/', name: 'app_backend_journee_scientifique_index', methods: ['GET'])]
    public function index(EtudiantRepository $etudiantRepository): Response
    {
        return $this->render('backend_journee_scientifique/index.html.twig', [
            'etudiants' => $etudiantRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_backend_journee_scientifique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etudiant);
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_journee_scientifique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_journee_scientifique/new.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_journee_scientifique_show', methods: ['GET'])]
    public function show(Etudiant $etudiant): Response
    {
        return $this->render('backend_journee_scientifique/show.html.twig', [
            'etudiant' => $etudiant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backend_journee_scientifique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtudiantType::class, $etudiant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_journee_scientifique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_journee_scientifique/edit.html.twig', [
            'etudiant' => $etudiant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_journee_scientifique_delete', methods: ['POST'])]
    public function delete(Request $request, Etudiant $etudiant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etudiant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etudiant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backend_journee_scientifique_index', [], Response::HTTP_SEE_OTHER);
    }
}
