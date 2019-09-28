<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InformationController extends AbstractController
{
    /**
     * @Route("/information/{_locale}", name="information", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function index()
    {
        return $this->render('information/information.html.twig', [
            'controller_name' => 'InformationController',
        ]);
    }
}
