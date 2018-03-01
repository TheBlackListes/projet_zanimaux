<?php

namespace EvenementBundle\Controller;

use EvenementBundle\Entity\Participation;
use EvenementBundle\Entity\Evenement;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;



class ParticipationController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    public function participerAction($id)
    {
        $participation= new Participation();


        $em = $this->getDoctrine()->getManager();

        $evenement = $em->getRepository('EvenementBundle:Evenement')->find($id);

        $evenement->setNbrParticipant($evenement->getNbrParticipant()+1);

            $participation->setIdEvenement($evenement);
            $user=$this->getUser();
            $participation->setIdUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($participation);
            $em->flush();

            return$this->redirectToRoute('event_index');




    }

    public function abandonnerAction($id)
{

    $user=$this->getUser();
    $id_user=$user->getId();
    $em = $this->getDoctrine()->getManager();
    $participation=$em->getRepository("EvenementBundle:Participation")->findOneBy(array("id_user"=>$id_user,"id_evenement"=>$id));

    $em = $this->getDoctrine()->getManager();

    $evenement = $em->getRepository('EvenementBundle:Evenement')->find($id);

    $evenement->setNbrParticipant($evenement->getNbrParticipant()-1);

    $em->remove($participation);
    $em->flush();

    return $this->redirectToRoute('event_index');


}
    public function abandonnerunevenementAction($id)
    {

        $user=$this->getUser();
        $id_user=$user->getId();
        $em = $this->getDoctrine()->getManager();
        $participation=$em->getRepository("EvenementBundle:Participation")->findOneBy(array("id_user"=>$id_user,"id_evenement"=>$id));
        $em = $this->getDoctrine()->getManager();

        $evenement = $em->getRepository('EvenementBundle:Evenement')->find($id);

        $evenement->setNbrParticipant($evenement->getNbrParticipant()-1);
        $em->remove($participation);
        $em->flush();

        return $this->redirectToRoute('event_index');


    }

    public function abandonnerprofilAction($id)
    {

        $user=$this->getUser();
        $id_user=$user->getId();
        $em = $this->getDoctrine()->getManager();
        $participation=$em->getRepository("EvenementBundle:Participation")->findOneBy(array("id_user"=>$id_user,"id_evenement"=>$id));
        $em = $this->getDoctrine()->getManager();

        $evenement = $em->getRepository('EvenementBundle:Evenement')->find($id);

        $evenement->setNbrParticipant($evenement->getNbrParticipant()-1);
        $em->remove($participation);
        $em->flush();

        return $this->redirectToRoute('event_meseparticipation');


    }


}
