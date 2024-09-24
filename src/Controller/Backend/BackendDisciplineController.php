<?php

namespace App\Controller\Backend;

use App\Entity\Discipline;
use App\Form\DisciplineType;
use App\Repository\DisciplineRepository;
use App\Service\AllRepositories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/discipline')]
class BackendDisciplineController extends AbstractController
{
    public function __construct(
        private AllRepositories $allRepositories
    )
    {
    }

    #[Route('/', name: 'app_backend_discipline_index', methods: ['GET','POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, DisciplineRepository $disciplineRepository): Response
    {
        $discipline = new Discipline();
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->allRepositories->slug($discipline);
            $entityManager->persist($discipline);
            $entityManager->flush();

            sweetalert()->addSuccess("La discipline a été ajoutée avec succès!");

            return $this->redirectToRoute('app_backend_discipline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_discipline/index.html.twig', [
            'disciplines' => $disciplineRepository->findAll(),
            'discipline' => $discipline,
            'form' => $form,
            'suppression' => false
        ]);
    }

    #[Route('/new', name: 'app_backend_discipline_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $discipline = new Discipline();
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($discipline);
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_discipline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_discipline/new.html.twig', [
            'discipline' => $discipline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_discipline_show', methods: ['GET'])]
    public function show(Discipline $discipline): Response
    {
        return $this->render('backend_discipline/show.html.twig', [
            'discipline' => $discipline,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backend_discipline_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Discipline $discipline, EntityManagerInterface $entityManager,  DisciplineRepository $disciplineRepository): Response
    {
        $form = $this->createForm(DisciplineType::class, $discipline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->allRepositories->slug($discipline);
            $entityManager->flush();

            sweetalert()->addSuccess("La discipline {$discipline->getTitre()} a été ajoutée avec succès!");

            return $this->redirectToRoute('app_backend_discipline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_discipline/edit.html.twig', [
            'disciplines' => $disciplineRepository->findAll(),
            'discipline' => $discipline,
            'form' => $form,
            'suppression' => true
        ]);
    }

    #[Route('/{id}', name: 'app_backend_discipline_delete', methods: ['POST'])]
    public function delete(Request $request, Discipline $discipline, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discipline->getId(), $request->request->get('_token'))) {
            $entityManager->remove($discipline);
            $entityManager->flush();

            sweetalert()->addSuccess("La discipline {$discipline->getTitre()} a été supprimée avec succès!");
        }

        return $this->redirectToRoute('app_backend_discipline_index', [], Response::HTTP_SEE_OTHER);
    }
}
