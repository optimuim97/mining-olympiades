<?php

namespace App\Controller\Api;

use App\Entity\Etudiant;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/api/scientifique')]
class ApiScientifiqueController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private EtudiantRepository $etudiantRepository
    )
    {
    }

    #[Route('/', name: 'api_scientifique_etudiant', methods: ['POST'])]
    public function etudiant(Request $request): Response
    {
        $sauvegarde = $this->saveEtudiant($request);
        if(!$sauvegarde){
            return $this->json([
                'statut' => false
            ], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            'statut' => true
        ], Response::HTTP_OK);
    }

    private function saveEtudiant(Request $request): bool
    {
        $slug = (new AsciiSlugger())->slug(htmlspecialchars(
            strtolower($request->get('nom').'-'.$request->get('prenoms').'-'.$request->get('contact'))
        ));

        // Verification de la non existence de l'etudiant dans la table
        $verif = $this->etudiantRepository->findOneBy(['slug' => $slug]);
        if ($verif) return false;

        $etudiant = new Etudiant();
        $etudiant->setReference($this->generateLicence());
        $etudiant->setNom(htmlspecialchars($request->get('nom')));
        $etudiant->setPrenoms(htmlspecialchars($request->get('prenoms')));
        $etudiant->setEmail(htmlspecialchars($request->get('email')));
        $etudiant->setContact(htmlspecialchars($request->get('contact')));
        $etudiant->setNiveau(htmlspecialchars($request->get('niveau')));
        $etudiant->setFiliere(htmlspecialchars($request->get('filiere')));
        $etudiant->setSlug($slug);

        $this->entityManager->persist($etudiant);
        $this->entityManager->flush();

        return true;

    }

    public function generateLicence(): string
    {
        do{
            $lettre_aleatoire = chr(random_int(0,25) + ord('A'));
            $nombre_aleatoire = random_int(10000,99999);

            $licence = date('y').'-'.$nombre_aleatoire.$lettre_aleatoire;

            $verifLicence = $this->etudiantRepository->findOneBy(['reference' => $licence]);

        } while($verifLicence);

        return $licence;

    }
}