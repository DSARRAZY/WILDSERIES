<?php
// src/Controller/WildController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

Class WildController extends AbstractController
{
    /**
     * @Route("/wild", name="wild_index")
     */
    public function index() :Response
    {
        return $this->render('wild/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }

    /**
     * @Route("wild/show/{slug<^[a-z0-9-]+$>}", defaults={"slug" = null}, name="show")
     * @param string $slug The slugger
     * @return Response
     */
    public function show(?string $slug): Response
    {
        if (!$slug) {
            $slug = "Aucune série sélectionnée, veuillez choisir une série";
        }
        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        return $this->render('wild/show.html.twig', [
            'slug' => $slug,
        ]);
    }
}


