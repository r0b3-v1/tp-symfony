<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\EleveRepository;
use App\Repository\NoteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    /**
     * @Route("eleve/{id}/nouvelle-note", name="app_note_ajouter")
     */
    public function ajouter($id,EleveRepository $er, NoteRepository $nr, Request $request): Response
    {
        $eleve = $er->find($id);
        $note = new Note;
        $form = $this->createForm(NoteType::class, $note)->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $note->setEleve($eleve);
            $nr->add($note);
            return $this->redirectToRoute('app_eleve_details',['id'=>$id]);
        }

        return $this->render('formulaires/ajout.html.twig', [
            'form' => $form->createView(),
            'titreajout' => 'une note pour '.$eleve->getPrenom().' '.$eleve->getNom()
        ]);
    }
}
