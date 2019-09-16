<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Participant;
use App\Form\ParticipantFormType;
use Paydunya;

class ReservationController extends AbstractController
{
    /**
     * @Route("/participant/list", name="participant_list")
     */
    public function list(Request $request)
    {
        $participants = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->findAll();

        return $this->render('reservation/list.html.twig', [
            'participants' => $participants,
            'controller_name' => 'ReservationController',
        ]);
    }

    /**
     * @Route("/reservation", name="reservation")
     */
    public function add(Request $request)
    {
        $participant = new Participant();

        $form = $this->createForm(ParticipantFormType::class, $participant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
            $participant->setFrais([ParticipantFormType::BPI, ParticipantFormType::NBPI, ParticipantFormType::GALA]);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participant);
            $entityManager->flush();

            return $this->redirectToRoute('participant_show', [
                'id' => $participant->getId()
            ]);
        }

        return $this->render('reservation/inscription.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ReservationController',
        ]);
    }


    /**
     * @Route("/participant/{id}", name="participant_show")
     */
    public function show($id)
    {
        $participant = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->find($id);

        if (!$participant) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        return $this->render('reservation/show.html.twig', ['participant' => $participant]); 
    }

    /**
     * @Route("/participant/edit/{id}", name="participant_update")
     */
    public function update($id, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $participant = $entityManager->getRepository(Participant::class)->find($id);

        if (!$participant) {
            throw $this->createNotFoundException(
                'No participant found for id '.$id
            );
        }

        $form = $this->createForm(ParticipantFormType::class, $participant);
        
        
        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()){
            
            $entityManager = $this->getDoctrine()->getManager();
            
            $entityManager->flush();

            return $this->redirectToRoute('participant_show', [
                'id' => $participant->getId()
            ]);
        }

        return $this->render('reservation/edit.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ReservationController',
        ]);
    }

    /**
     * @Route("/participant/delete/{id}", name="participant_delete")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Participant::class)->find($id);

        if (!$participant) {
            throw $this->createNotFoundException(
                'No participant found for id '.$id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();
    }
}