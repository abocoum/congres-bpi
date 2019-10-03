<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contact;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index()
    {
        $contact = new Contact();

        $form = $this->createForm(ContactFormType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $message = (new \Swift_Message('Message bien réçu, nous vous contacterons dans les plus bref délais. Merci'))
                ->setFrom($contact->email)
                ->setTo('support@congres-bpi-mali.org')
                ->setBody(
                    $this->renderView(
                        // templates/emails/registration.html.twig
                        'emails/contact.html.twig',
                        ['name' => $name]
                    ),
                    'text/html'
                )

                // you can remove the following code if you don't define a text version for your emails
                ->addPart(
                    $this->renderView(
                        // templates/emails/registration.txt.twig
                        'emails/registration.txt.twig',
                        [$contact->name => $name]
                    ),
                    'text/plain'
                )
            ;

            $mailer->send($message);
        }
        return $this->render('message/index.html.twig', [
            'controller_name' => 'MessageController',
        ]);
    }
}
