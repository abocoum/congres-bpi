<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Participant;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/participant/list", name="admin")
     */
    public function index()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $participants = $entityManager->getRepository(Participant::class)->findAll();
        
        return $this->render('admin/list.html.twig', [
            'participants' => $participants,
            'controller_name' => 'AdminController',
        ]);
    }
}
