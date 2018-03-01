<?php

namespace VeterinaireBundle\Controller;

use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use VeterinaireBundle\Entity\NoteVeterinaire;
use VeterinaireBundle\Entity\Veterinaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use VeterinaireBundle\Form\VeterinairerechercheType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Veterinaire controller.
 *
 */
class VeterinaireController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $veterinaires = $em->getRepository('VeterinaireBundle:Veterinaire')->findAll();

        return $this->render('VeterinaireBundle:veterinaire:index.html.twig', array(
            'veterinaires' => $veterinaires,
        ));
    }

    public function indexVeterinaire_backAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
$veterinaire=new Veterinaire();
        $veterinaires = $em->getRepository('VeterinaireBundle:Veterinaire')->findAll();
        $Form=$this->createForm(VeterinairerechercheType::class,$veterinaire);
        if($request->isXmlHttpRequest())
        {
            $titre=$request->get('titre');
            $veterinaires=$em->getRepository('VeterinaireBundle:Veterinaire')->findvet($titre);
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);
            $content = $serializer->serialize($veterinaires, 'json');
            return new JsonResponse($content);
        }
        return $this->render('VeterinaireBundle:veterinaire:index_back.html.twig', array(
            'veterinaires' => $veterinaires,"Form"=>$Form->createView()
        ));
    }


    public function ajoutVeterinaireAction(Request $request)
    {
        $veterinaire = new Veterinaire();
        $form = $this->createForm('VeterinaireBundle\Form\VeterinaireType', $veterinaire);

        if($request->isMethod('Post'))
        { $form->handleRequest($request);
            $veterinaire = $form->getData();
            $veterinaire->setNote(0);
            $em = $this->getDoctrine()->getManager();

            $em->persist($veterinaire);
            $em->flush();

            return $this->redirectToRoute('veterinaire_affiche_back', array('id' => $veterinaire->getId()));
        }
        return $this->render('VeterinaireBundle:veterinaire:new.html.twig', array(
            'veterinaire' => $veterinaire,
            'form' => $form->createView(),));
    }


    public function listVeterinaireAction(Veterinaire $veterinaire)
    {


        return $this->render('VeterinaireBundle:veterinaire:show.html.twig', array(
            'veterinaire' => $veterinaire,

        ));
    }

    public function showVeterinaire_backAction(Veterinaire $veterinaire)
    {


        return $this->render('VeterinaireBundle:veterinaire:show_back.html.twig', array(
            'veterinaire' => $veterinaire,

        ));
    }


    public function editVeterinaireAction(Request $request, Veterinaire $id)
    {
        $em = $this->getDoctrine()->getManager();
        $veterinaire = $em->getRepository('VeterinaireBundle:Veterinaire')->find($id);
        $editForm = $this->createForm('VeterinaireBundle\Form\VeterinaireType', $veterinaire);


        if ($request->isMethod('Post'))
        {
            $editForm->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            $em->persist($veterinaire);
            $em->flush();
            return $this->redirectToRoute('veterinaire_affiche_back', array('id' => $veterinaire->getId()));
        }

        return $this->render('VeterinaireBundle:veterinaire:edit.html.twig', array(

            'form' => $editForm->createView(),

        ));
    }


    public function deleteVeterinaireAction($id)
    {

            $em = $this->getDoctrine()->getManager();
            $veterinaire=$em->getRepository("VeterinaireBundle:Veterinaire")->find($id);
            $em->remove($veterinaire);
            $em->flush();


        return $this->redirectToRoute('veterinaire_index_back');
    }

    public function showVeterinaire_frontAction(Veterinaire $veterinaire)
    {
        $em10 = $this->getDoctrine()->getManager();
        $vetsplusnoté = $em10->getRepository('VeterinaireBundle:Veterinaire')->troisPlusVeterinaireNoté();
        $i=0;
        $p=array();
        foreach ($vetsplusnoté as $vt)
        {if ($i<=3) {
            $i++;
            array_push($p, $vt);
        }
        }

        return $this->render('VeterinaireBundle:veterinaire:showVeterinaire_front.html.twig', array(
            'veterinaire' => $veterinaire,'vets' =>$p

        ));
    }
    public function  noteAction($idv,$note)
{
    $noteveterinaire=new NoteVeterinaire();
    $vet= new Veterinaire();
    $user=$this->getUser();
    $em=$this->getDoctrine()->getManager();
    $vet=$em->getRepository('VeterinaireBundle:Veterinaire')->findOneBy(array("id"=>$idv));

    $noteveterinaire->setIdVeterinaire($vet);
    $noteveterinaire->setNote($note);
    $em->persist($noteveterinaire);
    $nbrnotes=$em->getRepository("VeterinaireBundle:Veterinaire")->calculNbrNotes($vet->getId());
    $totalNote=$em->getRepository('VeterinaireBundle:Veterinaire')->calculSommeNotes($vet->getId());
    if ($nbrnotes==0){
        $moyenne=$note;
    }
    else{$moyenne=(integer)($totalNote+$note)/($nbrnotes+1);
    }
    $vet->setNote($moyenne);
    $em->persist($vet);
    $em->flush();
    $em = $this->getDoctrine()->getManager();

    $vet = $em->getRepository('VeterinaireBundle:Veterinaire')->findAll();

    return $this->render('VeterinaireBundle:veterinaire:index.html.twig',array('veterinaires'=>$vet));

}

    public function  note2Action($idv,$note)
    {
        $noteveterinaire=new NoteVeterinaire();
        $vet= new Veterinaire();
        $user=$this->getUser();
        $em=$this->getDoctrine()->getManager();
        $vet=$em->getRepository('VeterinaireBundle:Veterinaire')->findOneBy(array("id"=>$idv));

        $noteveterinaire->setIdVeterinaire($vet);
        $noteveterinaire->setNote($note);
        $em->persist($noteveterinaire);
        $nbrnotes=$em->getRepository("VeterinaireBundle:Veterinaire")->calculNbrNotes($vet->getId());
        $totalNote=$em->getRepository('VeterinaireBundle:Veterinaire')->calculSommeNotes($vet->getId());
        if ($nbrnotes==0){
            $moyenne=$note;
        }
        else{$moyenne=(integer)($totalNote+$note)/($nbrnotes+1);
        }
        $vet->setNote($moyenne);
        $em->persist($vet);
        $em->flush();
        $em = $this->getDoctrine()->getManager();

        $vet = $em->getRepository('VeterinaireBundle:Veterinaire')->find($idv);

        return $this->render('VeterinaireBundle:veterinaire:showVeterinaire_front.html.twig', array(
            'veterinaire' => $vet));
    }




    public function PdfAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $c = $em->getRepository('VeterinaireBundle:Veterinaire')->find($id);

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'VeterinaireBundle:Default:pdf.html.twig',
                    array(
                        'post'  => $c
                    )
                ),
                'C:\Users\Med Amine\Documents\file.pdf'
            ));

    }




}
