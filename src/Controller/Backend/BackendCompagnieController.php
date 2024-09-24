<?php

namespace App\Controller\Backend;

use App\Entity\Compagnie;
use App\Form\CompagnieType;
use App\Repository\CompagnieRepository;
use App\Service\AllRepositories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/compagnie')]
class BackendCompagnieController extends AbstractController
{
    public function __construct(private AllRepositories $allRepositories)
    {
    }

    #[Route('/', name: 'app_backend_compagnie_index', methods: ['GET', 'POST'])]
    public function index(Request $request, EntityManagerInterface $entityManager, CompagnieRepository $compagnieRepository): Response
    {
        $compagnie = new Compagnie();
        $form = $this->createForm(CompagnieType::class, $compagnie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->allRepositories->slug($compagnie);
//            dd($compagnie);

            // Verification de non existence
            $verif = $compagnieRepository->findOneBy(['slug' => $compagnie->getSlug()]);
            if ($verif){
                sweetalert()->addError("Echec, la compagnie '{$compagnie->getTitre()}' existe dans le système ");
                return $this->redirectToRoute('app_backend_compagnie_index');
            }

            $compagnie->setTitre(strtoupper($compagnie->getTitre()));
            $compagnie->setDg(strtoupper($compagnie->getDg()));
            $compagnie->setRepresentant(strtoupper($compagnie->getRepresentant()));

            $entityManager->persist($compagnie);
            $entityManager->flush();

            sweetalert()->addSuccess("La compagnie '{$compagnie->getTitre()}' a été ajoutée avec succès!");

            return $this->redirectToRoute('app_backend_compagnie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_compagnie/index.html.twig', [
            'compagnies' => $this->allRepositories->getAllCompagnieWithParticipant(),
            'compagnie' => $compagnie,
            'form' => $form,
            'suppression' => false
        ]);
    }

    #[Route('/new', name: 'app_backend_compagnie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $compagnie = new Compagnie();
        $form = $this->createForm(CompagnieType::class, $compagnie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($compagnie);
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_compagnie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_compagnie/new.html.twig', [
            'compagnie' => $compagnie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_compagnie_show', methods: ['GET'])]
    public function show(Compagnie $compagnie): Response
    {
        return $this->render('backend_compagnie/show.html.twig', [
            'compagnie' => $this->allRepositories->getOneCompagnieWithParticipants($compagnie->getId()),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backend_compagnie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Compagnie $compagnie, EntityManagerInterface $entityManager, CompagnieRepository $compagnieRepository): Response
    {
        $form = $this->createForm(CompagnieType::class, $compagnie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->allRepositories->slug($compagnie);
            $entityManager->flush();

            sweetalert()->addSuccess("La compagnie '{$compagnie->getTitre()} a été modifié avec succès!");

            return $this->redirectToRoute('app_backend_compagnie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_compagnie/edit.html.twig', [
            'compagnies' => $compagnieRepository->findAll(),
            'compagnie' => $compagnie,
            'form' => $form,
            'suppression' => true
        ]);
    }

    #[Route('/{id}', name: 'app_backend_compagnie_delete', methods: ['POST'])]
    public function delete(Request $request, Compagnie $compagnie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compagnie->getId(), $request->request->get('_token'))) {
            $entityManager->remove($compagnie);
            $entityManager->flush();

            sweetalert()->addSuccess("La compagnie '{$compagnie->getTitre()} a été supprimée avec succès!");
        }

        return $this->redirectToRoute('app_backend_compagnie_index', [], Response::HTTP_SEE_OTHER);
    }
}
