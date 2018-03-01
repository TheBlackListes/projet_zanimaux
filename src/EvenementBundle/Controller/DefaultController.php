<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ps\PdfBundle\Annotation\Pdf;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EvenementBundle:Default:index.html.twig');
    }

    public function contenantAction()
    {
        return $this->render('EvenementBundle:Default:content.html.twig');
    }
    public function pdfAction($id, Request $request) {
        // get contract from database
        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository(Evenement::class)->find($id);

        $path = $request->server->get('DOCUMENT_ROOT');    // C:/wamp64/www/
        $path = rtrim($path, "/");                         // C:/wamp64/www

        $html = $this->renderView('EvenementBundle:Default:content.html.twig', array('c' => $c));

        $header = $this->renderView('EvenementBundle:Default:header.html.twig', array(
            'path' => $path
        ));
        $footer = $this->renderView('EvenementBundle:Default:footer.html.twig', array(
            'customer' => $c->getCustomer()
        ));

        $output = $path . $request->server->get('BASE');        // C:/wamp64/www/project/web
        $output .= '/pdf/contract-'. $c->getCustomerCode() .'.pdf';

        // Generate PDF file
        $this->get('knp_snappy.pdf')->generateFromHtml($html, $output, array(
            'header-html' => $header,
            'footer-html' => $footer,
        ));

        // Message + redirection
        $this->addFlash('success', 'The PDF file has been saved.');
        return $this->redirectToRoute('contract');
    }

}
