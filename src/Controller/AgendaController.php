<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AgendaController extends AbstractController
{
    /**
     * @Route("/agenda/{_locale}", name="agenda", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function index()
    {
        return $this->render('agenda/agenda.html.twig', [
            'controller_name' => 'AgendaController',
        ]);
    }

    /**
     * @Route("/agenda-details/{_locale}", name="details", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function details()
    {
        return $this->render('agenda/details.html.twig', [
            'controller_name' => 'AgendaController',
        ]);
    }
}
