<?php

namespace App\Controller\Backend;

use App\Entity\Joueur;
use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Repository\JoueurRepository;
use App\Repository\ParticipantRepository;
use App\Service\AllRepositories;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/participant')]
class BackendParticipantController extends AbstractController
{
    public function __construct(
        private JoueurRepository $joueurRepository,
        private AllRepositories $allRepositories
    )
    {
    }

    #[Route('/', name: 'app_backend_participant_index', methods: ['GET'])]
    public function index(ParticipantRepository $participantRepository): Response
    {
//        dd($this->joueurRepository->findAll());
        return $this->render('backend_participant/index.html.twig', [
            'participants' => $this->joueurRepository->getAll(),
        ]);
    }

    #[Route('/new', name: 'app_backend_participant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($participant);
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_participant_show', methods: ['GET'])]
    public function show(Joueur $joueur): Response
    {
        return $this->render('backend_participant/show.html.twig', [
            'participant' => $this->allRepositories->getProfileJoueur($joueur->getId()),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_backend_participant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Joueur $joueur, EntityManagerInterface $entityManager): Response
    { dd($joueur);
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_backend_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('backend_participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_backend_participant_delete', methods: ['POST'])]
    public function delete(Request $request, Participant $participant, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$participant->getId(), $request->request->get('_token'))) {
            $entityManager->remove($participant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_backend_participant_index', [], Response::HTTP_SEE_OTHER);
    }
}
