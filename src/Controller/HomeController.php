<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/congres", name="congres")
     */
    public function description()
    {
        return $this->render('home/description.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/comite-executif", name="comite-executif")
     */
    public function commiteExecutif()
    {
        return $this->render('home/membre.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}
