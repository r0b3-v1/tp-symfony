<?php

namespace App\Controller;

use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EleveController extends AbstractController
{
    /**
     * @Route("/eleves", name="app_eleve")
     */
    public function index(EleveRepository $er): Response
    {
        $eleves = $er->findAll();
        return $this->render('eleve/index.html.twig', [
            'eleves' => $eleves,
        ]);
    }
}
