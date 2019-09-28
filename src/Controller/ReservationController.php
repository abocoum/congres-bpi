<?php

namespace App\Controller;

use Paydunya\Checkout\CheckoutInvoice;
use Paydunya\Checkout\Store;
use Paydunya\Setup;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\Participant;
use App\Form\ParticipantFormType;
use Paydunya;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation/{_locale}", name="reservation", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
     */
    public function add(Request $request)
    {
        $participant = new Participant();

        $form = $this->createForm(ParticipantFormType::class, $participant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
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
     * @Route("/participant/{id}/{_locale}", name="participant_show", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
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
     * @Route("/participant/edit/{id}/{_locale}", name="participant_update", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
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

        return $this->render('reservation/inscription.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'ReservationController',
        ]);
    }

    /**
     * @Route("/participant/delete/{id}/{_locale}", name="participant_delete", defaults={"_locale": "fr"}, requirements={"_locale": "fr|en"})
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

        Setup::setMasterKey($_ENV["PAYDUNYA_MASTER_KEY"]);
        Setup::setPublicKey($_ENV["PAYDUNYA_PUBLIC_KEY"]);
        Setup::setPrivateKey($_ENV["PAYDUNYA_PRIVATE_KEY"]);
        Setup::setToken($_ENV["PAYDUNYA_TOKEN"]);

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
        $invoice->addTax("Billet non membre BPI", 150);
        $invoice->addTax("Gala entrée", 30);
        $invoice->setTotalAmount(100000);


        // Le code suivant décrit comment créer une facture de paiement au niveau de nos serveurs,
        // rediriger ensuite le client vers la page de paiement
        // et afficher ensuite son reçu de paiement en cas de succès.
        $iscreated = $invoice->create();
        var_dump($iscreated);
        if($invoice->create()) {
            return $this->redirect($invoice->getInvoiceUrl());
        }else{
            echo $invoice->response_text;
        }
        return $this->render('reservation/show.html.twig', ['participant' => $participant]);
    }

    /**
     * @Route("/participant/callback_payement/{id}", name="callback_payement")
     */
    public function callbackPayement($id, Request $request)
    {
        try {





            $form = $this->createFormBuilder()
                ->add('data', TextType::class)
                ->getForm();
            $form->handleRequest($request);
            $data = $request->request->get('data');

            var_dump($data);
            if ($form->isSubmitted() && $form->isValid()) {
                // data is an array with "name", "email", and "message" keys
                $data = $form->getData();
                var_dump($data);

            }

            if($data == null) {
                die("Paiement a echoué veuillez reessayer avec un autre moyen de paiement");
            }
echo  hash('sha512', $_ENV["PAYDUNYA_MASTER_KEY"]);
            //Prenez votre MasterKey, hashez la et comparez le résultat au hash reçu par IPN
            if($data['hash'] === hash('sha512', $_ENV["PAYDUNYA_MASTER_KEY"])) {

                if ($data['status'] == "completed") {
                    //Faites vos traitements backoffice ici...
                    $entityManager = $this->getDoctrine()->getManager();
                    $participant = $entityManager->getRepository(Participant::class)->find($id);

                    if (!$participant) {
                        throw $this->createNotFoundException(
                            'No participant found for id '.$id
                        );
                    }
                    $participant->setPrenom("Paiement effectue");

                    return $this->render('reservation/show.html.twig', ['participant' => $participant]);

                }
            } else {
                die("Cette requête n'a pas été émise par PayDunya");
            }
        } catch(Exception $e) {
            die();
        }
    }

}