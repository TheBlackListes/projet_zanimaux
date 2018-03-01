<?php

namespace AnimauxBundle\Controller;

use AnimauxBundle\Entity\Animaux;
use AnimauxBundle\Form\RechercheBackIdType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnimauxAdminController extends Controller
{

    public function indexAction(Request $request)
    {
        $animal = new Animaux();
        $em=$this->getDoctrine()->getManager();
        $animaux=$em->getRepository("AnimauxBundle:Animaux")->findAll();

        $Form=$this->createForm(RechercheBackIdType::class,$animal);
        $Form->handleRequest($request);

        if($Form->isValid())
        {
            $id=$animal->getId();
            $animaux=$em->getRepository("AnimauxBundle:Animaux")->findidDQL($id);
        }
        return $this->render("AnimauxBundle:animaux:Back/index.html.twig",
            array('Form'=>$Form->createView(),'animauxes'=>$animaux));
    }

    public function autoriserAnimalAction(Request $request)
    {
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $animal = $em->getRepository('AnimauxBundle:Animaux')->find($id);

            $em = $this->getDoctrine()->getManager();
            $animal->setEtat("valide");
            $em->persist($animal);
            $em->flush();

        return $this->redirectToRoute('animaux_index');
    }

    public function bloquerAnimalAction(Request $request)
    {
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $animal = $em->getRepository('AnimauxBundle:Animaux')->find($id);

        $em = $this->getDoctrine()->getManager();
        $animal->setEtat('bloque');
        $em->persist($animal);
        $em->flush();

        return $this->redirectToRoute('animaux_index');
    }



    public function showAction(Animaux $animaux)
    {
        return $this->render('AnimauxBundle:animaux/Back:show.html.twig', array(
            'animaux' => $animaux
        ));
    }


}
