<?php

namespace MyAppMailBundle\Controller;
use MyAppMailBundle\Form\MailType;
use MyAppMailBundle\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;
use Symfony\Component\HttpFoundation\Response;

class MailController extends Controller
{
    public function index1Action($name)
    {
        return $this->render('', array('name' => $name));
    }


    public function indexAction(Request $request)
    {
        $mail = new Mail();
        $form= $this->createForm(MailType::class, $mail);
        $form->handleRequest($request) ;
        if ($form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Accusé de réception')
                ->setFrom('zanimauxzanimaux@gmail.com')
                ->setTo($mail->getEmail())
                ->setBody(
                    $this->renderView(
                        'MyAppMailBundle:Default:email.html.twig',
                        array('nom' => $mail->getNom(), 'prenom'=>$mail->getPrenom())
                    ),
                    'text/html'
                );
            $this->get('mailer')->send($message);
            return $this->redirect($this->generateUrl('my_app_mail_accuse'));
        }
        return $this->render('MyAppMailBundle:Default:index.html.twig',
            array('form'=>$form->createView()));
    }



    public function successAction(){
        return new Response("email envoyé avec succès, Merci de vérifier votre boite mail.");
    }


}
