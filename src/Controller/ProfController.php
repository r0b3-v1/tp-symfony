<?php

namespace App\Controller;

use App\Repository\ProfRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
