<?php

namespace App\Controller\Api;

use App\Entity\Adhesion;
use App\Repository\AdhesionRepository;
use App\Service\GestionMedia;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[Route('/api/adhesion')]
class ApiAdhesionController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private AdhesionRepository $adhesionRepository,
        private GestionMedia $gestionMedia
    )
    {
    }

    #[Route('/', name: 'api_adhesion_add',methods: ['POST'])]
    public function add(Request $request)
    {
        $data = json_decode($request->getContent(), true);

         $mediaFile = $request->files->get('media');

        $adhesion = new Adhesion();
        $adhesion->setCivilite($request->get('civilite'));
        $adhesion->setNom($request->get('nom'));
        $adhesion->setPrenoms($request->get('prenoms'));
        $adhesion->setFonction($request->get('fonction'));
        $adhesion->setEntreprise($request->get('entreprise'));
        $adhesion->setEmail($request->get('email'));
        $adhesion->setTelephone($request->get('telephone'));
        $adhesion->setAdresse($request->get('adresse'));
        $adhesion->setSlug((new AsciiSlugger())->slug(strtolower($request->get('entreprise'))));

        if ($mediaFile){
            $adhesion->setMedia($this->gestionMedia->upload($mediaFile, 'adhesion'));
        }

        $this->entityManager->persist($adhesion);
        $this->entityManager->flush();

//        sweetalert()->addSuccess("Votre demande a été envoyée avec succès! Vous serez contacté dans un sous peu.");

        return $this->json([
            'message' => 'Adhésion ajoutée avec succès!'
        ], Response::HTTP_OK);
    }
}