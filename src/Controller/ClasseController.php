<?php

namespace App\Controller;

use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClasseController extends AbstractController
{
    /**
     * @Route("/classes", name="app_classe")
     */
    public function index(ClasseRepository $cr): Response
    {
        $classes = $cr->findAll();
        return $this->render('classe/index.html.twig', [
            'classes' => $classes,
        ]);
    }
}
