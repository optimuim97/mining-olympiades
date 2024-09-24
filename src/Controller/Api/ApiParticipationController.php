<?php

namespace App\Controller\Api;

use App\Entity\Competir;
use App\Entity\Participant;
use App\Repository\CompagnieRepository;
use App\Repository\CompetirRepository;
use App\Repository\DisciplineRepository;
use App\Service\AllRepositories;
use App\Service\GestionMedia;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/api/participation')]
class ApiParticipationController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $em,
        private CompagnieRepository $compagnieRepository,
        private DisciplineRepository $disciplineRepository,
        private AllRepositories $allRepositories,
        private GestionMedia $gestionMedia,
        private CompetirRepository $competirRepository
    )
    {
    }

    #[Route('/', name: 'api_participation_add', methods: ['POST'])]
    public function add(Request $request)
    {
        try {
            $compagnieId = $request->request->getInt('compagnie');
            $disciplineId = $request->request->getInt('discipline');
            $nom = $request->request->get('nom');
            $prenoms = $request->request->get('prenoms');
            $matricule = $request->request->get('matricule');
            $contact = $request->request->get('contact');
            $email = $request->request->get('email');
            $mediaFile = $request->files->get('media');
            $reglement = $request->request->get('reglement');
            $image = $request->request->get('image');

            $participant = $this->createParticipant($nom, $prenoms, $matricule, $contact, $email, $mediaFile, $compagnieId);
            $discipline = $this->disciplineRepository->findOneBy(['id' => $disciplineId]);

            // Vérifions si le participant ne s'est pas encore inscrit dans la discipline
            $nonInscrit = $this->competirRepository->findOneBy(['participant' => $participant, 'discipline' => $discipline]);
            if ($nonInscrit){
                sweetalert()->addError("Echec! vous êtes déjà inscit(e) dans cette discipline");
                return $this->json([
                    'statut' => 'echec',
                    'message' => "Vous êtes déjà inscrit(e) à cette discipline"
                ]);
            }

            $this->createCompetir($participant, $discipline);

            $this->em->flush();

            sweetalert()->addSuccess("Votre demande de participation a été enregistrée avec succès!");

            return $this->json([
                'statut' => 'success',
                "message" => "Votre participation à cette discipline a été enregistrée avec succès!",
                "slug" => $participant->getSlug()
            ]);

        }catch(\Exception $e){
            return $this->json([
                'status' => 'success',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }


    }

    private function createParticipant($nom, $prenoms, $matricule, $contact, $email, mixed $mediaFile, int $compagnieId)
    {
        // Vérifions si le participant n'existe pas deja dans le système pour éviter les doublons
        $slug = (new AsciiSlugger())->slug(strtolower($nom."-".$prenoms."-".$matricule));
        $participant = $this->allRepositories->getUniqueParticipant($slug);
        if (!$participant){
            $entityCompagnie = $this->compagnieRepository->findOneBy(['id'=> $compagnieId]);

            $participant = new Participant();
            $participant->setNom($nom);
            $participant->setPrenoms($prenoms);
            $participant->setMatricule($matricule);
            $participant->setContact($contact);
            $participant->setEmail($email);
            $participant->setSlug($slug);
            $participant->setMedia($this->gestionMedia->upload($mediaFile, 'participant'));
            $participant->setCompagnie($entityCompagnie);
            $participant->setLicence($this->allRepositories->generateLicence());

            $this->em->persist($participant);
        }

        return $participant;
    }

    private function createCompetir(?Participant $participant, ?\App\Entity\Discipline $discipline): void
    {
        $competir = new Competir();
        $competir->setParticipant($participant);
        $competir->setDiscipline($discipline);
        $competir->setAnnee(date('Y'));
        $competir->setCreatedAt(new \DateTime());

        $this->em->persist($competir);
    }


}