<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{


    /**
     * @Route("/{_locale}", name="home", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function index(Request $request)
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/congres/{_locale}", name="congres", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function description()
    {
        return $this->render('home/description.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/comite-executif/{_locale}", name="comite-executif", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function commiteExecutif()
    {
        return $this->render('home/membre.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/commission-organisation/{_locale}", name="commission-organisation", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function commiteOrganisation()
    {
        return $this->render('home/commission.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/galerie/{_locale}", name="galerie", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function galerie()
    {
        return $this->render('home/galerie.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/president-commission/{_locale}", name="president", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function president()
    {
        return $this->render('home/president.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}
