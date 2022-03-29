<?php

namespace App\Controller;

use App\Entity\Prof;
use App\Form\ProfType;
use App\Repository\ProfRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfController extends AbstractController
{
    /**
     * @Route("/profs", name="app_prof")
     */
    public function index(ProfRepository $pr): Response
    {
        $profs = $pr->findAll();
        return $this->render('prof/index.html.twig', [
            'profs' => $profs,
        ]);
    }

    /**
     * @Route("/profs/ajouter", name="app_prof_ajouter")
     */
    public function ajouter(ProfRepository $pr, Request $request): Response{
        $prof = new Prof;
        $form = $this->createForm(ProfType::class, $prof)
                    ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $pr->add($prof);
            return $this->redirectToRoute('app_prof');
        }

        return $this->render('formulaires/ajout.html.twig',[
            'form'=>$form->createView(),
            'titreform'=>'Ajouter un professeur'
        ]);
    }

    /**
     * @Route("/prof/{id}/supprimer", name="app_prof_supprimer")
     */
    public function supprimer($id, ProfRepository $pr): Response{
        $prof = $pr->find($id);
        $pr->remove($prof);
        return $this->redirectToRoute('app_prof');
    }
}
