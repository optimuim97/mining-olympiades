<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/carousel')]
class ApiCarouselController extends AbstractController
{
    #[Route('/', name: 'api_carousel_list', methods: ['GET'])]
    public function list(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            return $this->json([
                'error' => "Method not allowed"
            ]);
        }
        $content = [
            'titre' => "Présentation",
            'contenu' => "<p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Maxime nostrum blanditiis fugit dolores. Exercitationem distinctio perferendis beatae? Officiis distinctio iusto voluptas enim nobis cumque corporis consequatur. Fuga ab amet placeat!
                        </p>
                        <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, molestias dicta officia voluptatem dolorum laboriosam dolorem aperiam modi, necessitatibus, odit facere quibusdam ad incidunt est maiores? Perspiciatis, natus! Esse, deserunt?
                        </p>",
            'media' => 'illustration2.png'
        ];

        return $this->json($content);
    }
}