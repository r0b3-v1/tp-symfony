<?php

namespace App\Controller;

use App\Repository\MatiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MatiereController extends AbstractController
{
    /**
     * @Route("/matieres", name="app_matiere")
     */
    public function index(MatiereRepository $mr): Response
    {
        $matieres = $mr->findAll();
        return $this->render('matiere/index.html.twig', [
            'matieres' => $matieres,
        ]);
    }
}
