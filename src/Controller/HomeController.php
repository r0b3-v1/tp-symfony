<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/reglement", name="app_reglement_interieur")
     */
    public function reglementInterieur(): Response
    {
        return $this->render('home/reglement.html.twig');
    }

    /**
     * @Route("/contact", name="app_contact")
     */
    public function contacter(MailerInterface $mailer, Request $request): Response
    {
        $form = $this->createForm(ContactType::class)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objet = $form->getData()['Objet'];
            $message = $form->getData()['Message'];
            // évidemment pas fonctionnel, mais c'est pour le POC
            $email = (new Email())
                ->from('adresseaupif@test.com')
                ->to('monsite@truc.example')
                ->subject($objet)
                ->text($message);
            $mailer->send($email);
        }

        return $this->render('formulaires/ajout.html.twig', [
            'form' => $form->createView(),
            'titreform' => 'Nous contacter'
        ]);
    }
}
