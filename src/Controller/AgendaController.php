<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AgendaController extends AbstractController
{
    /**
     * @Route("/agenda", name="agenda")
     */
    public function index()
    {
        return $this->render('agenda/agenda.html.twig', [
            'controller_name' => 'AgendaController',
        ]);
    }

    /**
     * @Route("/agenda/details", name="details")
     */
    public function details()
    {
        return $this->render('agenda/details.html.twig', [
            'controller_name' => 'AgendaController',
        ]);
    }
}
