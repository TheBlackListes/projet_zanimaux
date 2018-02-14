<?php

namespace AnimauxBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AnimauxBundle:Default:index.html.twig');
    }
}
