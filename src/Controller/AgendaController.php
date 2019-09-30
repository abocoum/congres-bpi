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
     * @Route("/agenda-details-14-novembre-2019/{_locale}", name="details_1", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function details_1()
    {
        return $this->render('agenda/details_1.html.twig', [
            'controller_name' => 'AgendaController',
        ]);
    }

    /**
     * @Route("/agenda-details-15-novembre-2019/{_locale}", name="details_2", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function details_2()
    {
        return $this->render('agenda/details_2.html.twig', [
            'controller_name' => 'AgendaController',
        ]);
    }

    /**
     * @Route("/agenda-details-16-novembre-2019/{_locale}", name="details_3", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function details_3()
    {
        return $this->render('agenda/details_3.html.twig', [
            'controller_name' => 'AgendaController',
        ]);
    }
}
