<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/classes/ajouter", name="app_classe_ajouter")
     */
    public function ajouter(ClasseRepository $cr, Request $request): Response{
        $classe = new Classe;
        $form = $this->createForm(ClasseType::class, $classe)
                    ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $cr->add($classe);
            return $this->redirectToRoute('app_classe');
        }

        return $this->render('formulaires/ajout.html.twig',[
            'form'=>$form->createView(),
            'titreajout'=>'une classe'
        ]);
    }

    /**
     * @Route("/classe/{id}/supprimer", name="app_classe_supprimer")
     */
    public function supprimer($id, ClasseRepository $cr): Response{
        $classe = $cr->find($id);
        $cr->remove($classe);
        return $this->redirectToRoute('app_classe');
    }
}
