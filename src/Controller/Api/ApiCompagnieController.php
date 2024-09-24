<?php

namespace App\Controller\Api;

use App\Service\AllRepositories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/compagnie')]
class ApiCompagnieController extends AbstractController
{
    public function __construct(private AllRepositories $allRepositories)
    {
    }

    #[Route('/', name: 'api_compagnie_index', methods: ['GET'])]
    public function index()
    {
        $compagnies = $this->allRepositories->getAllCompagnie();

        return $this->json($compagnies);
    }
}