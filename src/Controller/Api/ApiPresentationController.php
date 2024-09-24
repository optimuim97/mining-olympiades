<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/presentation')]
class ApiPresentationController extends AbstractController
{
    #[Route('/', name: 'api_presentation_index', methods: ['GET'])]
    public function index()
    {
        $content = [
            'titre' => "Les Mining Olympiades",
            'contenu' => "<p>
                            Organisée en marge du traditionnel weekend de la Sainte Barbe (la fête mondiale des Mineurs), les Mining Olympiades se tiennent, chaque année, durant la première quinzaine du mois de décembre, depuis 2016 à Yamoussoukro. Concept créé par le Groupement Professionnel des Miniers de Côte d’Ivoire (GPMCI), principale faitière des entreprises minières privées en Côte d’Ivoire, les Mining Olympiades sont un moment de réjouissances en vue de créer et renforcer l’appartenance à la communauté minière présente en Côte d’ivoire.
                        </p>
                        <p>
                            La 8ème édition aura lieu les 15 et 16 décembre sur le thème : « Valorisons nos régions » et verra la participation de filiales de sociétés minières installées en Afrique de l’ouest.
                        </p>",
            'media' => 'illustration2.png',
            'media2' => 'sportifs.png'
        ];

        return $this->json($content);
    }
}