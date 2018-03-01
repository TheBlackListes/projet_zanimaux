<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EvenementBundle\Entity\Evenement;
use AppBundle\Entity\User;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need

        $em2 = $this->getDoctrine()->getManager();
        $evenements2 = $em2->getRepository('EvenementBundle:Evenement')->findbest();
        $i=0;
        $evenements=array();
        foreach ($evenements2 as $evenement)
        {
            if($i<3)
            {
                array_push($evenements,$evenement);
                $i= $i+1;
            }
        }


        return $this->render('front_office/default/index.html.twig', array(
            'evenements' => $evenements,

        ));

    }


    public function contactAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('back_office/default/index.html.twig');
    }




    /**
     * @Route("a-propos", name="pagabout")
     */
    public function aboutAction(Request $request)
    {
        $em2 = $this->getDoctrine()->getManager();
        $evenements2 = $em2->getRepository('EvenementBundle:Evenement')->findbest();
        $i=0;
        $evenements=array();
        foreach ($evenements2 as $evenement)
        {
            if($i<3)
            {
                array_push($evenements,$evenement);
                $i= $i+1;
            }
        }


        return $this->render('front_office/default/index.html.twig', array(
            'evenements' => $evenements,

        ));
    }


}
