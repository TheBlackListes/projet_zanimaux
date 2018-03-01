<?php

namespace ProduitBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use ProduitBundle\Entity\Produit;
use ProduitBundle\ProduitBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;


/**
 * Produit controller.
 *
 * @Route("Produit")
 */
class ProduitController extends Controller
{
    //Page d'index
    public function indexAction(Request $request)
    {
        $type=$request->get('type');
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('ProduitBundle:Produit')->AfficherProduitParType($type);



        return $this->render('ProduitBundle:produit:index.html.twig', array(
            'produits' => $produits,
        ));
    }


    /** @Route("/", name="Produit_mesproduit")
     * @Method("GET")
     */
    public function mesproduitsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $id_user=$this->getUser();

        $produits = $em->getRepository('ProduitBundle:Produit')->afficherproduitUser($id_user);

        return $this->render('@Produit/produit/mesproduits.html.twig', array(
            'produits' => $produits,
        ));
    }


    //Ajouter un nouveau produit
    public function newAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm('ProduitBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
          //  return new Response("form is Submitted");
            $em = $this->getDoctrine()->getManager();
            $produit->setIdMembre($user);
            $produit->upload();
            $produit->setVisibilite(1);
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('Produit_show',array('id'=>$produit->getId()));
        }


        return $this->render('@Produit/produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }


    /**
     * Finds and displays a produit entity.
     *
     * @Route("/{id}", name="Produit_show")
     * @Method("GET")
     */
    public function showAction(Produit $produit)
    {


        return $this->render('ProduitBundle:produit:show.html.twig', array(
            'produit' => $produit,

        ));
    }

    /**
     * Displays a form to edit an existing produit entity.
     *
     * @Route("/{id}/edit", name="Produit_edit")
     * @Method({"GET", "POST"})
     */

    public function editAction(Request $request, Produit $id)
    {

        $em= $this->getDoctrine()->getManager();
        $produit=$em->getRepository('ProduitBundle:Produit')->find($id);
        $form=$this->createForm('ProduitBundle\Form\ProduitType', $produit);


        if ($request->isMethod('Post'))
        {  $form->handleRequest($request);

            $em=$this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
            return $this->redirectToRoute('Produit_mesproduits', array('id' => $produit->getId()));

        }
        return $this->render('ProduitBundle:Produit:edit.html.twig',array(
            "form"=>$form->createView()));
    }


    /**
     * Deletes a produit entity.
     *
     * @Route("/{id}", name="Produit_delete")
     * @Method("DELETE")
     */
    public function DeleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository("ProduitBundle:Produit")->find($id);
        $em->remove($produit);
        $em->flush();
        return $this->redirectToRoute('Produit_mesproduit');
    }


    public function RechercheAction(Request $request)
    {
        if ($request->isMethod('post')){
            $chaine=$request->get('chaine');
            $categorie=$request->get('categorie');
            $em = $this->getDoctrine()->getManager();
            $produits = $em->getRepository('ProduitBundle:Produit')->Recherche($chaine,$categorie);

            return $this->render('ProduitBundle:produit:index.html.twig', array(
                'produits' => $produits,
            ));
        }

    }


    public function NombreUserAction (){
        $em = $this->getDoctrine();
        $Nbuser = $em->getRepository('ProduitBundle:Produit')->NbreUser();

        return $this->render(':back_office/default:index.html.twig',array('Nbuser' =>$Nbuser)
        );
    }


    /**
     * Graphe.
     *
     * @Route("/", name="Produit_graphe")
     * @Method("GET")
     */



    public function IndexBackAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('ProduitBundle:Produit')->findBy(array(), array('id'=> 'desc'));

        return $this->render('ProduitBundle:produit_back:index_back.html.twig', array(
            'produits' => $produits,
        ));
    }


    /**
     * @Route("/{id}", name="Produit_visibilite")
     */
    public function visibiliteAction(Produit $id)
    {
        $em= $this->getDoctrine()->getManager();


        $produits = $em->getRepository('ProduitBundle:Produit')->find($id);

        if($produits->getVisibilite() == 1){
            $produits->setVisibilite(0);
            $em->flush();
        }else{
            $produits->setVisibilite(1);
            $em->flush();
        }

        return $this->redirectToRoute('Produit_indexback');
    }


    public function GrapheFrontAction(){

        $em = $this->getDoctrine();
        $id_user=$this->getUser();
        $id_user->getId();

        //$produitsuser=$em->getRepository(Produit::class)->afficherproduitUser($id_user);

        $pieChart = new PieChart();


        $produitchien=$em->getRepository('ProduitBundle:Produit')->NombreProduitDuUserParCategorie($id_user->getId(),'Chien');
        $produitautre=$em->getRepository('ProduitBundle:Produit')->NombreProduitDuUserParCategorie($id_user->getId(),'Autre');
        $produitchat=$em->getRepository('ProduitBundle:Produit')->NombreProduitDuUserParCategorie($id_user->getId(),'Chat');

        //Calcul du nombre total des produits du user
        $produituser=$em->getRepository('ProduitBundle:Produit')->afficherproduitUser($id_user);
        $i=0;
        foreach ($produituser as $prod)
        {
            $i+=1;
        }



        $data=array();
        $stat=['Catégorie','nbProduit'];
        array_push($data,$stat);


            $stat=array();
           $pourcentagechien=($produitchien*100)/$i;
            array_push($stat,'Chien',$pourcentagechien);
            $stat=['Chien',$pourcentagechien];
            array_push($data,$stat);

      $stat=array();
      $pourcentagechat=($produitchat*100)/$i;
        array_push($stat,'Chat',$pourcentagechat);
        $stat=['Chat',$pourcentagechat];
        array_push($data,$stat);

       $stat=array();
        $pourcentageautre=($produitautre*100)/$i;
        array_push($stat,'Autre',$pourcentageautre);
        $stat=['Autre',$pourcentageautre];

        array_push($data,$stat);




        $pieChart->getData()->setArrayToDataTable(
            $data
        );

        $pieChart->getOptions()->setTitle('Pourcentage de vos produits publiés par catégorie');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(500);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('ProduitBundle:produit:graphe.html.twig', array('piechart' =>
            $pieChart,));
    }



}

