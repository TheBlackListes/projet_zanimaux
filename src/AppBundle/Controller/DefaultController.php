<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('front_office/default/index.html.twig');
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
        // replace this example code with whatever you need
        return $this->render('front_office/default/index.html.twig');
    }


}
