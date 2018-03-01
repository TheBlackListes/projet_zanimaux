<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Evenement;
use EvenementBundle\Entity\Participation;
use EvenementBundle\Form\EvenementType;
use EvenementBundle\Form\RechercherForm;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Validator\Constraints\DateTime;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;







class EvenementController extends Controller
{

    public function afficherlistAction(Request $request)
    {
        $id_user=$this->getUser();

        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('EvenementBundle:Evenement')->findAll();


        $em2 = $this->getDoctrine()->getManager();
        $evenements2 = $em2->getRepository('EvenementBundle:Evenement')->findbest();

        $i=0;
        $evenementbest=array();
        foreach ($evenements2 as $evenement)
        {
            if($i<3)
            {
                array_push($evenementbest,$evenement);
                $i= $i+1;
            }
        }


        $em1 = $this->getDoctrine()->getManager();
        $participations=$em1->getRepository('EvenementBundle:Participation')->findBy(array("id_user"=>$id_user));


        return $this->render('EvenementBundle:evenement:index.html.twig', array(
            'evenements' => $evenements,
            'evenementbest' => $evenementbest,
            'participations'=>$participations,


        ));
    }

    public function afficherlistbackAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('EvenementBundle:Evenement')->findAll();



        return $this->render('EvenementBundle:backoffice:affiche.html.twig', array(
            'evenements' => $evenements,



        ));
    }

    public function rechercheAction(Request $request)
    {

        $nom =$request->query->get('evenement');
        $en = $this->getDoctrine()->getManager();
        $evenements=$en->getRepository("EvenementBundle:Evenement")->findNom($nom);

        $id_user=$this->getUser();
        $em1 = $this->getDoctrine()->getManager();
        $participations=$em1->getRepository('EvenementBundle:Participation')->findBy(array("id_user"=>$id_user));
        return $this->render("EvenementBundle:evenement:index.html.twig",array(
            'evenements' => $evenements,
            'participations'=>$participations,
        ));
    }






    public function affichermesevenementAction()
    {
        $em = $this->getDoctrine()->getManager();

        $id_user=$this->getUser();

        $evenements = $em->getRepository('EvenementBundle:Evenement')->afficherevenementUser($id_user);

        return $this->render('EvenementBundle:Evenement:mes_evenement.html.twig', array(
            'evenements' => $evenements,
        ));
    }

    public function affichermesparticipationAction()
    {
        $evenements1=array();
        $id_user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('EvenementBundle:Evenement')->findAll();

        $em1 = $this->getDoctrine()->getManager();
        $participations=$em1->getRepository('EvenementBundle:Participation')->findBy(array("id_user"=>$id_user));


        foreach ($participations as $participation)
        {
            foreach ($evenements as $evenement)
            {
                if($participation->getIdEvenement()==$evenement)
                {
                    array_push($evenements1,$evenement);
                }
            }

        }
        return $this->render('EvenementBundle:evenement:mes_participation.html.twig', array(

            'evenements'=>$evenements1,
                )
        );
    }


    public function afficher_evenementAction(Evenement $evenement)
    {
        $id_user=$this->getUser();



        $em1 = $this->getDoctrine()->getManager();
        $participations=$em1->getRepository('EvenementBundle:Participation')->findBy(array("id_user"=>$id_user));





        return $this->render('EvenementBundle:evenement:afficher_un_evenement.html.twig', array(
            'evenement' => $evenement,
            'participations'=>$participations,
            ));
    }





    /**
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function ajouterAction(Request $request)
    {
        $evenement = new Evenement();
        $user=$this->getUser();
        $form = $this->createForm('EvenementBundle\Form\EvenementType', $evenement);

        if($request->isMethod('Post'))
        { $form->handleRequest($request);
            $dir="C:\wamp64\www\projet_zanimaux\web\images";
            $file=$form['image']->getData();
            $evenement->setImage($evenement->getNom().".png");
            $file->move($dir,$evenement->getImage());
            $evenement->setNbrParticipant(0);

        $evenement = $form->getData();
                        $evenement->setcreateur($user->getUsername());
            $evenement->setIdMembre($user);

                        $em = $this->getDoctrine()->getManager();
                        $em->persist($evenement);
                        $em->flush();

                        return $this->redirectToRoute('event_mesevenement', array('id' => $evenement->getId()));
            }
        return $this->render('EvenementBundle:evenement:new.html.twig', array(
            'evenement' => $evenement,
            'form' => $form->createView(),
        ));
    }
    public function ajouterbackAction(Request $request)
    {
        $evenement = new Evenement();
        $user=$this->getUser();
        $form = $this->createForm('EvenementBundle\Form\EvenementType', $evenement);

        if($request->isMethod('Post'))
        { $form->handleRequest($request);
            $dir="C:\wamp64\www\projet_zanimaux\web\images";
            $file=$form['image']->getData();
            $evenement->setImage($evenement->getNom().".png");
            $file->move($dir,$evenement->getImage());
            $evenement->setNbrParticipant(0);

            $evenement = $form->getData();
            $evenement->setcreateur($user->getUsername());
            $evenement->setIdMembre($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();

            return $this->redirectToRoute('event_afficheback');
        }
        return $this->render('EvenementBundle:backoffice:ajouter.html.twig', array(
            'evenement' => $evenement,
            'form' => $form->createView(),
        ));
    }
/*
    public function modifierAction(Request $request, Evenement $evenement)
    {

        $editForm = $this->createForm('EvenementBundle\Form\EvenementType', $evenement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_index', array('id' => $evenement->getId()));
        }

        return $this->render('EvenementBundle:evenement:edit.html.twig', array(
            'evenement' => $evenement,
            'edit_form' => $editForm->createView(),

        ));
    }
  */
    public function modifierAction(Request $request, Evenement $id)
    {

        $em= $this->getDoctrine()->getManager();
        $evenement=$em->getRepository('EvenementBundle:Evenement')->find($id);
        $form=$this->createForm('EvenementBundle\Form\EvenementType', $evenement);


        if ($request->isMethod('Post'))
        {  $form->handleRequest($request);

            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('event_mesevenement', array('id' => $evenement->getId()));

        }
        return $this->render('EvenementBundle:evenement:edit.html.twig',array(
            "form"=>$form->createView()));
    }


    public function supprimerAction($id)
    {

            $em = $this->getDoctrine()->getManager();
            $evenement=$em->getRepository("EvenementBundle:Evenement")->find($id);
            $em->remove($evenement);
            $em->flush();

        return $this->redirectToRoute('event_mesevenement');



    }

    public function supprimerbackAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $evenement=$em->getRepository("EvenementBundle:Evenement")->find($id);
        $em->remove($evenement);
        $em->flush();

        return $this->redirectToRoute('event_afficheback');



    }



}
