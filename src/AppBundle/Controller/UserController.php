<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function indexAction()
    {
        //$User=new User();
        $em = $this->getDoctrine()->getManager();

        $membres = $em->getRepository('AppBundle:User')->findByEnabled(true);
     //   $form = $this->createForm('Appbundle\Form\RechercheType', $User);
        $form= $this->createFormBuilder()->add('nom',TextType::class)->getForm();

        return $this->render('back_office/membre/liste.html.twig', array(
            'membres' => $membres,
            'form'=>$form->createView(),
        ));
    }
    public function rechAction(Request $request)
    {

        $search =$request->query->get('membre');
        $en = $this->getDoctrine()->getManager();
        $membre=$en->getRepository("AppBundle:User")->findNom($search);
        return $this->render("back_office/membre/index.html.twig",array(
            'membres' => $membre
        ));
    }


    public function bloquerAction(User $membre)
    {

        $em = $this->getDoctrine()->getManager();

        $membre->setEnabled(false);

        $em->flush();

        $this->addFlash('message', 'membre a été bloqué');

        return $this->redirectToRoute('membre_index');
    }

    public function listeBloqueAction()
    {
        $em = $this->getDoctrine()->getManager();

        $membres = $em->getRepository('AppBundle:User')->findByEnabled(false);

        return $this->render('back_office/membre/liste.html.twig', array(
            'membres' => $membres,
        ));
    }


    public function debloquerAction(User $membre)
    {

        $em = $this->getDoctrine()->getManager();

        $membre->setEnabled(true);

        $em->flush();

        $this->addFlash('message', 'membre a été debloqué');

        return $this->redirectToRoute('membre_index');
    }






}
