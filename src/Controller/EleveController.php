<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Repository\EleveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ClasseType;
use App\Form\EleveType;

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

    /**
     * @Route("/eleves/ajouter", name="app_eleve_ajouter")
     */
    public function ajouter(EleveRepository $er, Request $request): Response{
        $eleve = new Eleve;
        $form = $this->createForm(EleveType::class, $eleve)
                    ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $er->add($eleve);
            return $this->redirectToRoute('app_eleve');
        }

        return $this->render('formulaires/ajout.html.twig',[
            'form'=>$form->createView(),
            'titreajout'=>'un élève'
        ]);
    }
}
