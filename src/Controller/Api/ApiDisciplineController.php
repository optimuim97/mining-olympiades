<?php

namespace App\Controller\Api;

use App\Entity\Abonnement;
use App\Entity\Compagnie;
use App\Entity\Joueur;
use App\Entity\Membre;
use App\Repository\AbonnementRepository;
use App\Repository\CompetirRepository;
use App\Repository\DisciplineRepository;
use App\Repository\JoueurRepository;
use App\Repository\MembreRepository;
use App\Repository\ParticipantRepository;
use App\Service\AllRepositories;
use App\Service\GestionMedia;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/api/discipline')]
class ApiDisciplineController extends AbstractController
{
    public function __construct(
        private AllRepositories $allRepositories,
        private SerializerInterface $serializer,
        private MembreRepository $membreRepository,
        private AbonnementRepository $abonnementRepository,
        private DisciplineRepository $disciplineRepository,
        private EntityManagerInterface $entityManager,
        private GestionMedia $gestionMedia,
        private ParticipantRepository $participantRepository,
        private CompetirRepository $competirRepository,
        private JoueurRepository $joueurRepository
    )
    {
    }

    #[Route('/', name: 'api_discipline_index', methods: ['GET'])]
    public function index()
    {
        $discipline = $this->allRepositories->getAllDiscipline(); //dd($discipline);

        $jsonDiscipline = $this->serializer->serialize($discipline, 'json', ['groups' => 'participation']);

        //dd($jsonDiscipline);

        return new JsonResponse($jsonDiscipline, Response::HTTP_OK, [], true);
    }

    #[Route('/abonnement', name: 'api_discipline_abonnement', methods: ['POST'])]
    public function abonnement(Request $request)
    {
        $datas = json_decode($request->getContent(), true);
        if (!$datas || empty($datas['disciplines'])){
//            sweetalert()->addError("Echec, Veuillez choisir les disciplines !");
            return $this->json([
                'message' => "Echec, veuillez choisir les disciplines",
                'statut' => "Echec"
            ]);
        }

        // Utilisateur, verification du membre
        $user = $this->getUser();
        $membre = $this->membreRepository->findOneBy(['user' => $user]);
        if (!$membre){
            sweetalert()->addError("Echec, votre compte ne vous autorise pas à choisir des disciplines");
            return $this->json([
                'message' => "Echec, votre compte ne vous autorise pas à choisir des disciplines",
                'statut' => 'Echec'
            ], Response::HTTP_OK);
        }

        $abonnement = new Abonnement();
        $abonnement->setReference($this->reference());
        $abonnement->setCompagnie($membre->getCompagnie());
        $abonnement->setAnnee(date('Y'));
        $abonnement->setMontant($membre->getParticipation());
        $abonnement->setSolde(false);
        $abonnement->setRestantJoueur($datas['totalJoueurs']);
        $abonnement->setTotalJoueur($datas['totalJoueurs']);
        $abonnement->setCreatedAt(new \DateTime());

        foreach ($datas['disciplines'] as $data){
            $discipline =$this->disciplineRepository->findOneBy(['id' => $data]) ;
            if ($discipline) {
                $abonnement->addDiscipline($discipline);
            }
        }

        $this->entityManager->persist($abonnement);
        $this->entityManager->flush();

//        sweetalert()->addSuccess("Vos disciplines ont été sauvegardées avec succès!");

        return $this->json([
            'message' => 'Vos disciplines ont été sauvegardées avec succès!',
            'statut' => "success",
        ]);
    }

    #[Route('/participation', name: 'api_discipline_participation' ,methods: ['GET'])]
    public function participation(Request $request)
    {
        // Utilisateur, verification du membre
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


        $disciplines=[];
        foreach ($abonnement->getDisciplines() as $discipline){
            $disciplines[] = $discipline;
        }

        $jsonDiscipline = $this->serializer->serialize($disciplines, 'json', ['groups' => 'participation']);

        //dd($jsonDiscipline);

        return new JsonResponse($jsonDiscipline, Response::HTTP_OK, [], true);
    }

    #[Route('/participation/membre', name: 'api_discipline_membre', methods: ['POST'])]
    public function membre(Request $request)
    {
        $disciplineId = $request->request->get('discipline');
        $nom = $request->request->get('nom');
        $prenoms = $request->request->get('prenoms');
        $matricule = $request->request->get('matricule');
        $contact = $request->request->get('contact');
        $email = $request->request->get('email');
        $mediaFile = $request->files->get('media');
        $carteFile = $request->files->get('carte');

        // Vous pouvez également gérer le fichier uploadé (photo) ici
        $media = $request->files->get('media');

        // Utilisateur, verification du membre
        $user = $this->getUser();
        $membre = $this->membreRepository->findOneBy(['user' => $user]);
        if (!$membre){
//            sweetalert()->addError("Echec, votre compte ne vous autorise pas à choisir des disciplines");
            return $this->json([
                'message' => "Echec, votre compte ne vous autorise pas à choisir des disciplines",
                'statut' => 'Echec'
            ], Response::HTTP_OK);
        }

        $discipline = $this->disciplineRepository->findOneBy(['id'=> $disciplineId]);
        $abonnement = $this->abonnementRepository->findOneBy(['compagnie' => $membre->getCompagnie()]);

        $disciplineJoueurs = $this->joueurRepository->getNombreJoueurByAbonnementAndDiscipline($disciplineId, $abonnement->getId());

//        dd($disciplineJoueurs);

        if ((int)$disciplineJoueurs >= (int)$discipline->getJoueur()){
            return $this->json([
                'message' => "Echec, votre compte ne vous autorise pas à choisir des disciplines",
                'statut' => "disciplineAtteinte",
                'discipline' => $discipline->getTitre()
            ]);
        }

        $joueur = new Joueur();
        $joueur->setNom($nom);
        $joueur->setPrenoms($prenoms);
        $joueur->setContact($contact);
        $joueur->setEmail($email);
        $joueur->setMatricule($matricule);
        $joueur->setSlug((new AsciiSlugger())->slug(strtolower($nom.'-'.$prenoms.'-'.$matricule)));
        $joueur->setLicence($this->allRepositories->generateLicence());
        $joueur->setMedia($this->gestionMedia->upload($mediaFile, 'participant'));
        $joueur->setCarte($this->gestionMedia->upload($carteFile, 'participant'));
        $joueur->addDiscipline($discipline);
        $joueur->setAbonnement($abonnement);

        $this->entityManager->persist($joueur);

        // Mise a jour du nombre de joueurs restants
        $abonnement->setRestantJoueur((int)$abonnement->getRestantJoueur() - 1);

        $this->entityManager->flush();

//        sweetalert()->addSuccess("Le participant a été ajouté avec succès!");

        return $this->json([
            'message' => 'Le participant a été ajouté avec succès! avec succès!',
            'statut' => "success",
        ]);
    }

    #[Route('/membre/liste/', name: 'api_discipline_membre_liste', methods: ['GET'])]
    public function liste()
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

        $participants = $this->joueurRepository->getJoueurByCompagnie($membre->getCompagnie()); //dd($participants);

        $jsonParticipants = $this->serializer->serialize($participants, 'json', ['groups' => 'participation']); //dd($jsonParticipants);

        return new JsonResponse($jsonParticipants, Response::HTTP_OK, [], true);
    }

    #[Route('/options/choix/supplementaire/', name: 'api_discipline_choix_supplementaire', methods: ['GET'])]
    public function discipline()
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
        $disciplines = $this->disciplineRepository->getListeExclues();


        // Discipline concernée par
        $disciplineChoisies=[];
        foreach ($abonnement->getDisciplines() as $discipline){
            $disciplineChoisies[] = $discipline;
        }
        $disciplineConcernees = array_udiff($disciplines, $disciplineChoisies, function ($a, $b){
            return $a->getId() - $b->getId();
        });

        $jsonDiscipline = $this->serializer->serialize($disciplines, 'json', ['groups' => 'participation']);
        return new JsonResponse($jsonDiscipline, Response::HTTP_OK, [], true);
    }

    #[Route('/membre/delete/{id}', name: 'api_discipline_membre_delete', methods: ['DELETE'])]
    public function suppression(Joueur $joueur): JsonResponse
    {
        // Utilisateur, verification du membre
        $user = $this->getUser();
        $membre = $this->membreRepository->findOneBy(['user' => $user]);
        if (!$membre){
//            sweetalert()->addError("Echec, votre compte ne vous autorise pas à choisir des disciplines");
            return $this->json([
                'message' => "Echec, votre compte ne vous autorise pas à choisir des disciplines",
                'statut' => 'Echec'
            ], Response::HTTP_OK);
        }

//        $discipline = $this->disciplineRepository->findOneBy(['id'=> $disciplineId]);
        $abonnement = $this->abonnementRepository->findOneBy(['compagnie' => $membre->getCompagnie()]);

        $this->entityManager->remove($joueur);
        $joueur->getDiscipline()->clear();
        $this->gestionMedia->removeUpload($joueur->getMedia(), 'participant');

        // Mise a jour du nombre de joueurs restants
        $abonnement->setRestantJoueur((int)$abonnement->getRestantJoueur() + 1);
        $this->entityManager->flush();

        return new JsonResponse('Suppression OK', Response::HTTP_OK, [], true);
    }

    private function reference(): string
    {
        $last = $this->abonnementRepository->findOneBy([],['id'=>"DESC"]);
        $ref = $last ? $last->getId() : 1;

        if ($ref < 10) $ref = "0{$ref}";

        return date('ymd').$ref;
    }
}