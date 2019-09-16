<?php

namespace App\Controller;

use Paydunya\Checkout\CheckoutInvoice;
use Paydunya\Checkout\Store;
use Paydunya\Setup;
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
        $participant = $entityManager->getRepository(Participant::class)->find($id);

        if (!$participant) {
            throw $this->createNotFoundException(
                'No participant found for id '.$id
            );
        }

        $entityManager->remove($participant);
        $entityManager->flush();
    }


    /**
     * @Route("/participant/process_payement/{id}", name="process_payement")
     */
    public function processPayement($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $participant = $entityManager->getRepository(Participant::class)->find($id);

        if (!$participant) {
            throw $this->createNotFoundException(
                'No participant found for id '.$id
            );
        }

        Setup::setMasterKey("hmJ2xtPC-kED4-IRrC-ACJq-STiKu7xU74yc");
        Setup::setPublicKey("test_public_NrOpIYh0A9o8uIjiSxfnCge89wI");
        Setup::setPrivateKey("test_private_ffPBZhuRyTMQ8XBczl2oNohCxFb");
        Setup::setToken("Kta4Xit4wB0snCLvMPXs");
        Setup::setMode("test"); // Optionnel. Utilisez cette option pour les paiements tests.

        // configuration des informations vendeurs
        Store::setName("CODI Services"); // Seul le nom est requis
        Store::setTagline("Codi services pour le congrès bpi 2019");
        Store::setPhoneNumber("0022376893434");
        Store::setPostalAddress("Bamako - Mali");
        Store::setWebsiteUrl("http://www.codi-mali.com");
        Store::setLogoUrl("http://www.codi-mali.com/logo.png");
        Store::setCallbackUrl("http://localhost/participant/callback_payement");

        // creation de la commande
        $invoice = new CheckoutInvoice();

    }

    /**
     * @Route("/participant/callback_payement/{id}", name="process_payement")
     */
    public function callbackPayement($id, Request $request)
    {
        try {

            $form = $this->createFormBuilder()
                ->add('data', 'text')
                ->getForm();

            if ($request->getMethod() == 'POST') {
                $form->bindRequest($request);
                // data is an array with "name", "email", and "message" keys

                $data = $form->getData();
            }


            //Prenez votre MasterKey, hashez la et comparez le résultat au hash reçu par IPN
            if($data['hash'] === hash('sha512', "hmJ2xtPC-kED4-IRrC-ACJq-STiKu7xU74yc")) {

                if ($data['hash']['status'] == "completed") {
                    //Faites vos traitements backoffice ici...

                    $entityManager = $this->getDoctrine()->getManager();
                    $participant = $entityManager->getRepository(Participant::class)->find($id);

                    if (!$participant) {
                        throw $this->createNotFoundException(
                            'No participant found for id '.$id
                        );
                    }
                }
            } else {
                die("Cette requête n'a pas été émise par PayDunya");
            }
        } catch(Exception $e) {
            die();
        }
    }

}