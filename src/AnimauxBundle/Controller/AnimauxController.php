<?php

namespace AnimauxBundle\Controller;

use AnimauxBundle\Entity\Animaux;
use AnimauxBundle\Form\MailUserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AnimauxBundle\Repository\AnimauxRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AnimauxBundle\Form\AnimauxType;
use AnimauxBundle\Form\AnimauxForm;
use AppBundle\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;


class AnimauxController extends Controller
{

    public function afficheAnimauxAction(Request $request)
    {
        $type_offre=$request->get('type_offre');

        $em = $this->getDoctrine()->getManager();
        $animaux = $em->getRepository('AnimauxBundle:Animaux')->afficheAnimauxParOffre($type_offre);

        $animauxes  = $this->get('knp_paginator')->paginate($animaux, $request->query->getInt('page', 1), 4);

        return $this->render('AnimauxBundle:animaux/Front:indexList.html.twig', array(
            'animauxes' => $animauxes, 'type_offre'=>$type_offre,
        ));
    }

    public function afficheplusAction(Request $request)
    {
        $type_offre=$request->get('type_offre');

        $em = $this->getDoctrine()->getManager();
        $animaux = $em->getRepository('AnimauxBundle:Animaux')->afficheplusdate($type_offre);

        $animauxes  = $this->get('knp_paginator')->paginate($animaux, $request->query->getInt('page', 1), 4);

        return $this->render('AnimauxBundle:animaux/Front:indexList.html.twig', array(
            'animauxes' => $animauxes,'type_offre'=>$type_offre,
        ));
    }
    public function affichemoinAction(Request $request)
    {
        $type_offre=$request->get('type_offre');

        $em = $this->getDoctrine()->getManager();
        $animaux = $em->getRepository('AnimauxBundle:Animaux')->affichemoinsdate($type_offre);

        $animauxes  = $this->get('knp_paginator')->paginate($animaux, $request->query->getInt('page', 1), 4);

        return $this->render('AnimauxBundle:animaux/Front:indexList.html.twig', array(
            'animauxes' => $animauxes,'type_offre'=>$type_offre,
        ));
    }

    public function afficheDescriptionAction(Request $request)
    {
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $animauxes = $em->getRepository('AnimauxBundle:Animaux')->find($id);

        //ajouter une visite
        $var=$animauxes->getVisite()+1;
        $animauxes->setVisite($var);
        var_dump($var);
        $em->persist($animauxes);
        $em->flush();

        return $this->render('AnimauxBundle:animaux/Front:indexDescription.html.twig', array(
            'animaux' => $animauxes,
        ));

    }

    public function reclamerAction(Request $Request)
    {
        $id=$Request->get('id');

        $em = $this->getDoctrine()->getManager();

        $animal = $em->getRepository('AnimauxBundle:Animaux')->find($id);
        $animal->setEtat('suspect');
        $em->persist($animal);
        $em->flush();

        // Envoi du Mail
        $Request = $this->container->get('request_stack')->getCurrentRequest();
        if($Request->getMethod() == 'POST')
        {
            $subject=$Request->get('subject');
            $email = $Request->get('email');
            $nom = $Request->get('nom');
            $tel = $Request ->get('tel');
            $text = $Request ->get('text');
            //var_dump($nom,$email,$id,$tel,$text);

            $message= \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setCharset('utf-8')
                ->setFrom($email)
                ->setTo('medamine.brahmi1@gmail.com')
                ->setBody(
                    $this->renderView(
                        'AnimauxBundle:animaux:SwiftMailer/mailAdmin.html.twig',
                        array('nom' => $nom,'tel'=>$tel,'text'=>$text,'id'=>$id)
                    ), 'text/html');

             $this->get('mailer')->send($message);
        }
        return $this->render('AnimauxBundle:animaux/Front:indexDescription.html.twig', array(
            'animaux' => $animal,));
    }

    public function sendMailAction(Request $Request)
    {
        $id=$Request->get('id');
        $em = $this->getDoctrine()->getManager();
        $animal = $em->getRepository('AnimauxBundle:Animaux')->find($id);

        $propietaire_mail=$animal->getProprietaire->GetEmail();
        var_dump($propietaire_mail);

        $Request = $this->container->get('request_stack')->getCurrentRequest();
        if($Request->getMethod() == 'POST')
        {
            $email = $Request->get('email');
            $tel = $Request ->get('tel');
            $text = $Request ->get('text');
            var_dump($email,$tel,$text);

            $message = (new \Swift_Message('Zanimaux'))
                ->setCharset('utf-8')
                ->setFrom($email)
                ->setTo($propietaire_mail)
                ->setBody(
                    $this->renderView(
                        'AnimauxBundle:animaux:SwiftMailer/mailUser.html.twig',
                        array('tel'=>$tel,'text'=>$text,'animal'=>$animal)
                    ), 'text/html');

            $this->get('mailer')->send($message);
        }
        return $this->render('AnimauxBundle:animaux/Front:indexDescription.html.twig', array(
            'animaux' => $animal,));
    }

        public function rechercheIndexAction(Request $Request)
    {
        $Request = $this->container->get('request_stack')->getCurrentRequest();
        if($Request->getMethod() == 'POST')
        {
            $race = $Request->get('race');
            $type = $Request ->get('type');
            $offre = $Request ->get('offre');
            $sexe = $Request->get('sexe');
            $age = $Request ->get('age');
            $energie = $Request ->get('energie');
            $force = $Request ->get('force');
            $sociabilite = $Request ->get('sociabilite');
            $intelligence = $Request ->get('intelligence');
            $prix = $Request ->get('prix');

            var_dump($race,$type,$offre,$sexe,$age,$prix,$energie,$force,$sociabilite,$intelligence);
        }
        return $this->render('AnimauxBundle:Default:index.html.twig');
    }

    public function memberPetsListAction(Request $request)
    {
        $id_user=$this->getUser();

        $em = $this->getDoctrine()->getManager();

        $animaux = $em->getRepository('AnimauxBundle:Animaux')->afficheAnimauxUser($id_user);

        //$animauxes  = $this->get('knp_paginator')->paginate($animaux, $request->query->getInt('page', 1), 4);


        return $this->render('AnimauxBundle:animaux/Front:memberPetsList.html.twig', array('animaux' => $animaux));
    }

    public function memberPetsListDescriptionAction(Request $request)
    {
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();

        $animauxes = $em->getRepository('AnimauxBundle:Animaux')->find($id);

        return $this->render('AnimauxBundle:animaux/Front:memberPetDescription.html.twig', array('animaux' => $animauxes));
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */

    public function ajouterAnimalAction(Request $request)
    {
        $animaux = new Animaux();
        $form = $this->createForm('AnimauxBundle\Form\AnimauxType', $animaux);
        $form->handleRequest($request);
        $user=$this->getUser();
        $date= new\DateTime('now') ;

        if ($request->isMethod('Post')) {

            $dir="C:\wamp64\www\projet_zanimaux\web\images";
            $file=$form['photo']->getData();
            $animaux->setPhoto( $animaux->getNom().".png");
            $file->move($dir,$animaux->getPhoto());

            $animaux=$form->getData();
            $animaux->setProprietaire($user);
            $animaux->setDate($date);

            $em = $this->getDoctrine()->getManager();
            $em->persist($animaux);
            $em->flush();

            return $this->redirectToRoute('animaux_User_List');
        }

        return $this->render('AnimauxBundle:animaux/Front:FormulaireAjoutAnimal.html.twig', array(
            'animaux' => $animaux,
            'form' => $form->createView(),
        ));
    }

    public function modifierAnimalAction(Request $request)
    {
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $animal = $em->getRepository('AnimauxBundle:Animaux')->find($id);

        $Form = $this->createForm(AnimauxType::class, $animal);
        $Form->handleRequest($request);

        if ($Form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();

            $dir="C:\wamp64\www\projet_zanimaux\web\images";
            $file=$Form['photo']->getData();
            $animal->setPhoto( $animal->getNom().".png");
            $file->move($dir,$animal->getPhoto());

            $em->persist($animal);
            $em->flush();
            return $this->redirectToRoute('animaux_User_List');
        }
        return $this->render('AnimauxBundle:animaux/Front:FormulaireModifierAnimal.html.twig', array('form' => $Form->createView()));
    }

    public function supprimerAnimalAction($id)
    {
        $em=$this->getDoctrine()->getManager();
        $animal=$em->getRepository("AnimauxBundle:Animaux")->find($id);
        $em->remove($animal);
        $em->flush();
        return $this->redirectToRoute('animaux_User_List');
    }

}
