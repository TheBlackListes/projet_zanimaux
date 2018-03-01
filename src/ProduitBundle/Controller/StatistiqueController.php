<?php

namespace ProduitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

class StatistiqueController extends Controller
{
    public function StatProduitParCategorieAction(){

        $em = $this->getDoctrine();

        $pieChart = new PieChart();


        $produitchien=$em->getRepository('ProduitBundle:Produit')->NombreProduitParCategorie('Chien');
        $produitautre=$em->getRepository('ProduitBundle:Produit')->NombreProduitParCategorie('Autre');
        $produitchat=$em->getRepository('ProduitBundle:Produit')->NombreProduitParCategorie('Chat');

        $produits = $em->getRepository('ProduitBundle:Produit')->findAll();
        $i=0;
        foreach ($produits as $prod)
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

        $pieChart->getOptions()->setTitle('Pourcentage des par catégorie');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(500);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('ProduitBundle:produit_back:Stat.html.twig', array('piechart' =>
            $pieChart,));
    }

    public function NombreUserAction (){
        $em = $this->getDoctrine();
        $user=$this->getUser();
        $Nbuser = $em->getRepository('ProduitBundle:Produit')->NbreUser();
        $NbAnimaux = $em->getRepository('ProduitBundle:Produit')->NbreAnimaux();
        $NbProduit = $em->getRepository('ProduitBundle:Produit')->NbreProduits();
        $NbAnnonce = $em->getRepository('ProduitBundle:Produit')->NbreAnnonces();
        $NbEvenement = $em->getRepository('ProduitBundle:Produit')->NbreEvenements();

        $pieChart = new PieChart();


        $produitchien=$em->getRepository('ProduitBundle:Produit')->NombreProduitParCategorie('Chien');
        $produitautre=$em->getRepository('ProduitBundle:Produit')->NombreProduitParCategorie('Autre');
        $produitchat=$em->getRepository('ProduitBundle:Produit')->NombreProduitParCategorie('Chat');

        $produits = $em->getRepository('ProduitBundle:Produit')->findAll();
        $i=0;
        foreach ($produits as $prod)
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

        $pieChart->getOptions()->setTitle('Produits par catégorie');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(500);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        //Stat animaaux

        $pieChart1 = new PieChart();


        $chien=$em->getRepository('ProduitBundle:Produit')->NombreAnimauxParCategorie('Chien');
        $chat=$em->getRepository('ProduitBundle:Produit')->NombreProduitParCategorie('Chat');


        $animaux = $em->getRepository('ProduitBundle:Produit')->NbreAnimaux();


        $data1=array();
        $stat1=['Catégorie','nbAnimaux'];
        array_push($data1,$stat1);


        $stat1=array();
        $pourcentagechien=($chien*100)/$animaux;
        array_push($stat1,'Chien',$pourcentagechien);
        $stat1=['Chien',$pourcentagechien];
        array_push($data1,$stat1);

        $stat1=array();
        $pourcentagechat=($chat*100)/$animaux;
        array_push($stat1,'Chat',$pourcentagechat);
        $stat1=['Chat',$pourcentagechat];
        array_push($data1,$stat1);

        $pieChart1->getData()->setArrayToDataTable(
            $data1
        );

        $pieChart1->getOptions()->setTitle('Animaux par catégorie');
        $pieChart1->getOptions()->setHeight(500);
        $pieChart1->getOptions()->setWidth(400);
        $pieChart1->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart1->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart1->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart1->getOptions()->getTitleTextStyle()->setFontSize(20);



        return $this->render(':back_office/default:index.html.twig',array('User' => $user,
            'Nbuser' =>$Nbuser,
                'piechart1' => $pieChart1,
                'piechart' => $pieChart,
                'NbAnimaux' =>$NbAnimaux,
                'NbProduit' =>$NbProduit,
                'NbAnnonce' =>$NbAnnonce,
                'NbEvenement' =>$NbEvenement,


                )
        );


    }






}
