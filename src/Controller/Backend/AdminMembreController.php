<?php

namespace App\Controller\Backend;

use App\Entity\Membre;
use App\Entity\User;
use App\Repository\CompagnieRepository;
use App\Repository\MembreRepository;
use App\Repository\UserRepository;
use Composer\Semver\Comparator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/membre')]
class AdminMembreController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MembreRepository $membreRepository,
        private UserRepository $userRepository,
        private CompagnieRepository $compagnieRepository,
        private UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    #[Route('/', name: 'app_admin_membre_index')]
    public function index()
    {
        return $this->render('backend_membre/index.html.twig',[
            'membres' => $this->membreRepository->findAll()
        ]);
    }

    #[Route('/new', name: 'app_admin_membre_new', methods: ['GET','POST'])]
    public function new(Request $request)
    {
        if ($this->isCsrfTokenValid('add-membre', $request->get('_csrf_token'))){

            $traitement = $this->form($request);
            if ($traitement){
                sweetalert()->addSuccess("Le membre a été ajouté avec succès!");

                return $this->redirectToRoute('app_admin_membre_index');
            }

            sweetalert()->addError("Echec! Associer une compagnie au membre");

            return $this->render('backend_membre/new.html.twig',[
                'compagnies' => $this->compagnieRepository->findAll(),
                'membre' => null
            ]);
        }
        return $this->render('backend_membre/new.html.twig',[
            'compagnies' => $this->compagnieRepository->findAll(),
            'membre' => null,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_membre_edit')]
    public function edit(Request $request, Membre $membre)
    {
        if ($this->isCsrfTokenValid('add-membre', $request->get('_csrf_token'))){

            $traitement = $this->form($request, $membre->getUser(), $membre);
            if ($traitement){
                sweetalert()->addSuccess("Le membre a été ajouté avec succès!");

                return $this->redirectToRoute('app_admin_membre_index');
            }

            sweetalert()->addError("Echec! Associer une compagnie au membre");

            return $this->render('backend_membre/new.html.twig',[
                'compagnies' => $this->compagnieRepository->findAll(),
                'membre' => $membre
            ]);
        }

        return $this->render('backend_membre/new.html.twig',[
            'compagnies' => $this->compagnieRepository->findAll(),
            'membre' => $membre,
        ]);
    }

    private function form($request, $user = null, $membre = null): bool
    {
        $requestCompagnie = $request->get('_compagnie');
        $requetEmail = $request->get('_email');
        $requestPassword = $request->get('_password');
        $requestParticipation = $request->get('_participation');

        // Recherche de la compagnie
        $compagnie = $this->compagnieRepository->findOneBy(['id' => (int) $requestCompagnie]);
        if (!$compagnie){
            return false;
        }

        // Enregistrement de l'user
        if (!$user) {
            $user = new User();
        }
        $user->setEmail($requetEmail);
        $user->setPassword($this->passwordHasher->hashPassword($user, $requestPassword));
        $user->setRoles(['ROLE_USER']);
        $this->entityManager->persist($user);

        // Enregistrement du membre
        if (!$membre) {
            $membre = new Membre();
        }
        $membre->setCompagnie($compagnie);
        $membre->setUser($user);
        $membre->setParticipation((int) $requestParticipation);
        $this->entityManager->persist($membre);

        $this->entityManager->flush();

        return true;
    }
}