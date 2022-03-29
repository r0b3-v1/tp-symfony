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
use App\Form\RechercheType;

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
    public function ajouter(EleveRepository $er, Request $request): Response
    {
        $eleve = new Eleve;
        $form = $this->createForm(EleveType::class, $eleve)
            ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $er->add($eleve);
            return $this->redirectToRoute('app_eleve');
        }

        return $this->render('formulaires/ajout.html.twig', [
            'form' => $form->createView(),
            'titreform' => 'Ajouter un élève'
        ]);
    }

    /**
     * @Route("/eleve/{id}/supprimer", name="app_eleve_supprimer")
     */
    public function supprimer($id, EleveRepository $er): Response
    {
        $eleve = $er->find($id);
        $er->remove($eleve);
        return $this->redirectToRoute('app_eleve');
    }

    /**
     * @Route("/eleve/{id}/details", name="app_eleve_details")
     */
    public function details($id, EleveRepository $er): Response
    {
        $eleve = $er->find($id);

        return $this->render('eleve/details.html.twig', [
            'eleve' => $eleve,
        ]);
    }

    /**
     * @Route("/recherche-eleve", name="app_eleve_recherche")
     */
    public function rechercher(Request $request, EleveRepository $er)
    {
        $form = $this->createForm(RechercheType::class)->handleRequest($request);
        $results = [];

        if ($form->isSubmitted() && $form->isValid()) {

            $data = explode(' ', $form->getData()['keywords']);
            foreach ($data as $val) {
                $val = '%'.$val.'%';
                $resultNom = $er->createQueryBuilder('e')
                            ->where('e.nom LIKE :val')
                            ->setParameter('val',$val)
                            ->getQuery()
                            ->execute()
                            ;
                $resultPrenom = $er->createQueryBuilder('e')
                            ->where('e.prenom LIKE :val')
                            ->setParameter('val',$val)
                            ->getQuery()
                            ->execute()
                            ;

                $results = array_merge($results, $resultNom, $resultPrenom);
            }
            $results = array_unique($results);
        }

        return $this->render('formulaires/recherche.html.twig', [
            'form' => $form->createView(),
            'titreform' => 'Rechercher des élèves',
            'resultats' => $results
        ]);
    }
}
