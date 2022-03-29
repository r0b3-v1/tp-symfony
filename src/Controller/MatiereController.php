<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\MatiereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/matieres/ajouter", name="app_matiere_ajouter")
     */
    public function ajouter(MatiereRepository $mr, Request $request): Response{
        $matiere = new Matiere;
        $form = $this->createForm(MatiereType::class, $matiere)
                    ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $mr->add($matiere);
            return $this->redirectToRoute('app_matiere');
        }

        return $this->render('formulaires/ajout.html.twig',[
            'form'=>$form->createView(),
            'titreajout'=>'une matière'
        ]);
    }
}
