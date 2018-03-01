<?php

namespace AnnonceBundle\Controller;

use AnnonceBundle\AnnonceBundle;
use AnnonceBundle\Entity\Annonce;
use AnnonceBundle\Entity\Commentaire;
use AnnonceBundle\Form\AnnonceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Annonce controller.
 *
 */
class AnnonceController extends Controller
{
    /**
     * Lists all annonce entities.
     *
     */
    public function annoncesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isMethod('POST')) {
            $region = $request->get('region');
            $periode = $request->get('periode');
            $service = $request->get('service');

//recuperer la liste de tous les annonce
            $annonces = $em->getRepository('AnnonceBundle:Annonce')->recherche($region, $periode, $service);

            /**
             * @var $paginator \knp\Component\Pager\Paginator
             */
            $paginator = $this->get('knp_paginator');
            $result = $paginator->paginate(

                $annonces,
                $request->query->getInt('page', 1),
                $request->query->getInt('limit', 4)
            );
            dump(get_class($paginator));

            return $this->render('@Annonce/Annonce/test.html.twig', array(
                'annonces' => $result,
            ));
        }
    }
    
    
    
    
    
    
    
    public function index1Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//recuperer la liste de tous les annonce
        $annonces = $em->getRepository('AnnonceBundle:Annonce')->findAll();
        /**
         * @var $paginator \knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result=$paginator->paginate(

            $annonces,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',4)
        );
        dump(get_class($paginator));

        return $this->render('@Annonce/Annonce/test.html.twig', array(
            'annonces' => $result,
        ));
    }
    public function index2Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
//recuperer la liste de tous les annonce
        $annonces = $em->getRepository('AnnonceBundle:Annonce')->findAll();
        /**
         * @var $paginator \knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result=$paginator->paginate(

            $annonces,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',4)
        );
        dump(get_class($paginator));

        return $this->render('@Annonce/Annonce/test.html.twig', array(
            'annonces' => $result,
        ));
    }
    public function AnnonceParTypeAction(Request $request)
    {
        $type=$request->get('type');
        $em = $this->getDoctrine()->getManager();
//recuperer la liste de tous les annonce
        $annonces = $em->getRepository('AnnonceBundle:Annonce')->afficheAnnonceParType($type);
        /**
         * @var $paginator \knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result=$paginator->paginate(

            $annonces,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',4)
        );
        dump(get_class($paginator));
        return $this->render('@Annonce/Annonce/test.html.twig', array(
            'annonces' =>  $result,
        ));
    }

    public function mesannonceAction()
    {
        $em = $this->getDoctrine()->getManager();

        $id_user=$this->getUser();

        $annonces = $em->getRepository('AnnonceBundle:Annonce')->afficherAnnonceUser($id_user);

        return $this->render('@Annonce/Annonce/mes_annonce.html.twig', array(
            'annonces' => $annonces,
        ));
    }

    public function mesannonceInactiveAction()
    {
        $em = $this->getDoctrine()->getManager();

        $id_user=$this->getUser();

        $annonces = $em->getRepository('AnnonceBundle:Annonce')->mesAnnonceInactiveUser($id_user);

        return $this->render('@Annonce/Annonce/mes_annonce.html.twig', array(
            'annonces' => $annonces,
        ));
    }


    /**
     * Creates a new annonce entity.
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function voirProfilUserAction($id , Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);


        $commentaire = new Commentaire();
        $form = $this->createForm('AnnonceBundle\Form\CommentaireType', $commentaire);
        $form->handleRequest($request);
        $em1 = $this->getDoctrine()->getManager();
        $commentaires = $em1->getRepository('AnnonceBundle:Commentaire')->rechCommentaire($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $commentaire->setIdUser($user);
            $commentaire->setIdReviewer($this->getUser());
            $commentaire->setDate($this->date = new \DateTime(' Now'));
            $em->persist($commentaire);
            $em->flush();

            return $this->redirectToRoute('voirProfile', array('id' => $id));
        }


        return $this->render('@Annonce/Annonce/voirProfil.html.twig', array(
            'user' => $user,
            'commentaire' => $commentaire,
            'form' => $form->createView(),
            'commentaires' => $commentaires,
        ));
    }

    /**
     * Creates a new annonce entity.
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function proposerAction(Request $request)
    {
        $annonce = new Annonce();
        $form = $this->createForm('AnnonceBundle\Form\AnnonceType', $annonce);
        $form->handleRequest($request);
        $user = $this->getUser(); // recuperer l'utilisateur couurrant qui est entrain de proposer l'annonce

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dir="c:\wamp64\www\projet_zanimaux\web\image";
            $file=$form['image']->getData();
            $annonce->setImage($annonce->getTitre()."-".$annonce->getId().".png");
            $file->move($dir,$annonce->getImage());
            $annonce->setMembre($user);
            $em->persist($annonce);
            $em->flush();

            return $this->redirectToRoute('affiche_annonce', array('id' => $annonce->getId()));
        }

        return $this->render('@Annonce/Annonce/proposer2.html.twig', array(
            'annonce' => $annonce,
            'form' => $form->createView(),
        ));
    }


    public function afficheAction(Annonce $annonce)
    {


        return $this->render('@Annonce/Annonce/affiche.html.twig', array(
            'annonce' => $annonce,

        ));
    }


    public function modifierAction(Request $request, Annonce $annonce)
    {
        $editForm = $this->createForm('AnnonceBundle\Form\AnnonceType', $annonce);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('liste_annonce1');
        }

        return $this->render('@Annonce/Annonce/modifier.html.twig', array(
            'annonce' => $annonce,
            'form' => $editForm->createView(),

        ));
    }

    public function indexAdminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $annonces = $em->getRepository('AnnonceBundle:Annonce')->findAll();
        /**
         * @var $paginator \knp\Component\Pager\Paginator
         */
        $paginator=$this->get('knp_paginator');
        $result=$paginator->paginate(

            $annonces,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',4)
        );
        dump(get_class($paginator));

        return $this->render('@Annonce/back/Annonce/liste.html.twig', array(
            'annonces' => $result,
        ));


    }
    public function DeleteAnnonceAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $annonce = $em->getRepository("AnnonceBundle:Annonce")->find($id);
        $em->remove($annonce);
        $em->flush();
        return $this->redirectToRoute('MesAnnonce');
    }



}
