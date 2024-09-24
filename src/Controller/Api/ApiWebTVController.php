<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/webtv')]
class ApiWebTVController extends AbstractController
{
    #[Route('/', name: 'api_webtv_videos', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $videos = [
            [
                'titre' => "Cérémonie de lancement des Mining Olympiades 2023 ",
                'url' => "https://www.youtube-nocookie.com/embed/qP7xU4f-rRg?si=4k0c9NFRj1R10cnC",
                'media' => "20.jpg",
                'slug' => 'lancement-2023'
            ]
        ];

        return $this->json($videos);
    }

    #[Route('/{slug}', name: 'api_webtv_show', methods: ['GET'])]
    public function show($slug)
    {
        $video = [
            'titre' => "Cérémonie de lancement des Mining Olympiades 2023 ",
            'url' => "https://www.youtube-nocookie.com/embed/qP7xU4f-rRg?si=4k0c9NFRj1R10cnC",
            'media' => "20.jpg",
            'slug' => 'lancement-2023'
        ];

        return $this->json($video);
    }
}