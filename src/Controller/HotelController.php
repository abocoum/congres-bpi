<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HotelController extends AbstractController
{
    /**
     * @Route("/hôtel/{_locale}", name="hotel", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function index()
    {
        return $this->render('hotel/hotel.html.twig', [
            'controller_name' => 'HotelController',
        ]);
    }
}
