<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/activite')]
class ApiActiviteController extends AbstractController
{
    #[Route('/', name: 'api_activite_index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $activites = [
            [
                'titre' => "Journée <span>scientifique</span>",
                'resume' => '
                <ul>
                    <li><u>Thème</u>: <strong>«l’importance des politiques de santé et sécurité dans les mines»</strong></li>
                    <li><u>Date</u>: 15 décembre 2023 de 14h00 - 17h00</li>
                    <li><u>Lieu</u>: INPHB CENTRE</li>
                </ul>
                ',
                'icon' => 'icon-scientific-o.png',
                'media' => 'scientifique.png',
                'date' => "vendredi 15 décembre 2023",
                'lieu' => 'INPHB CENTRE',
                'heure' => "14h00 - 17h00"
            ],
            [
                'titre' => "Journée <span>sportive</span>",
                'resume' => '
                <ul>
                    <li><u>Discipline</u>: une trentaine de disciplines</li>
                    <li><u>Date</u>: 16 décembre 2023 de 07h00 - 17h30</li>
                    <li><u>Lieu</u>: INPHB CENTRE & SUD</li>
                </ul>
                ',
                'icon' => 'icon-sport.png',
                'media' => 'sports.png',
                'date' => "samedi 16 décembre 2023",
                'lieu' => 'INPHB CENTRE & SUD',
                'heure' => "7h00 - 17h30"
            ],
            [
                'titre' => "Soirée de <span>récompense</span>",
                'resume' => '
                <ul>
                    <li><u>Dress code</u>: Valorisons nos régions</li>
                    <li><u>Date</u>: 16 décembre 2023 de 19h30 - 23h00</li>
                    <li><u>Lieu</u>: HÔTEL HP RESORT (Ex-Hôtel Parlementaire)</li>
                </ul>
                ',
                'icon' => 'icon-gala.png',
                'media' => 'gala.png',
                'date' => "samedi 16 décembre 2023",
                'lieu' => 'Hôtel HP RESORT (Ex-Hôtel Parlementaire)',
                'heure' => "19h30 - 23h00"
            ]
        ];
        return $this->json($activites);
    }

    #[Route('/accueil', name: 'api_activite_accueil', methods: ['GET'])]
    public function accueil(): JsonResponse
    {
        $activites = [
            [
                'titre' => "Journée <span>scientifique</span>",
                'resume' => "En prélude au tournoi, cinq cents (500) jeunes gens, principalement issus de l'INPHB et en filières en lien  avec les métiers des mines, sont invités à rencontrer,     échanger et se rapprocher des professionnels miniers. 
Le thème retenu de cette année est: <strong>« l’importance des politiques de santé et sécurité dans les mines ».</strong>",
                'icon' => 'icon-scientific-o.png',
                'media' => 'scientifique.png',
                'date' => "vendredi 15 décembre 2023",
                'lieu' => 'INPHB CENTRE',
                'heure' => "14h00 - 17h00"
            ],
            [
                'titre' => "Journée <span>sportive</span>",
                'resume' => "Moment clé des Mining Olympiades, la journée sportive mettra en confrontation des équipes hommes ou femmes dans une trentaine de disciplines.",
                'icon' => 'icon-sport.png',
                'media' => 'sports.png',
                'date' => "samedi 16 décembre 2023",
                'lieu' => 'INPHB CENTRE & SUD',
                'heure' => "7h00 - 17h30"
            ],
            [
                'titre' => "Soirée de <span>recompense</span>",
                'resume' => "Pour cette 8ème édition et comme à l’accoutumée, le GPMCI organisera une soirée gala pour récompenser les vainqueurs et célébrer la fin d’année.  <br/>
A cette occasion, il seta demandé aux participants d'arborer une tenue traditionnelle, célébrant la région/zone d'intervention de la compagnie d'origine.
Un hommage sera rendu à des personnalités du secteur minier qui l’ont impacté",
                'icon' => 'icon-gala.png',
                'media' => 'gala.png',
                'date' => "samedi 16 décembre 2023",
                'lieu' => 'HÔTEL PRESIDENT',
                'heure' => "19h30 - 23h00"
            ]
        ];
        return $this->json($activites);
    }
}
