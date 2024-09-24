<?php

namespace App\Controller\Backend;

use App\Entity\Sponsor;
use App\Repository\SponsorRepository;
use App\Service\Utilities;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/backend/sponsoring')]
class BackendDemandeSponsorController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SponsorRepository $sponsorRepository,
        private Utilities $utilities
    )
    {
    }

    #[Route('/', name: 'app_backend_sponsoring_index')]
    public function index()
    {
        return $this->render('backend_sponsor/index.html.twig', [
            'sponsors' => $this->sponsorRepository->findBy([],['id'=>"DESC"]),
        ]);
    }

    #[Route('/{id}', name: 'app_backend_sponsoring_details', methods: ['GET','POST'])]
    public function details(Request $request, Sponsor $sponsor)
    {
//        dd($request);
        if ($this->isCsrfTokenValid('validation'.$sponsor->getId(), $request->get('_csrf_token'))){
            $this->utilities->validationSponsoring($sponsor);

            sweetalert()->addSuccess("Validation effectuée avec succès!");

            return $this->redirectToRoute('app_backend_sponsoring_index');
        }

        return $this->render('backend_sponsor/valider.html.twig', [
            'sponsor' => $sponsor
        ]);
    }

}