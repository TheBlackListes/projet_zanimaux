<?php

namespace AnimauxBundle\Controller;

use AnimauxBundle\Entity\Animaux;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AnimauxBundle\Form\AnimauxType;
use AnimauxBundle\Form\AnimauxForm;
use AppBundle\Entity\User;

/**
 * Animaux controller.
 *
 */
class AnimauxController extends Controller
{
    /**
     * Lists all animaux entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $animauxes = $em->getRepository('AnimauxBundle:Animaux')->findAll();

        return $this->render('animaux/Back/index.html.twig', array(
            'animauxes' => $animauxes,
        ));
    }

    public function afficheAnimauxAction(Request $request)
    {
        $type_offre=$request->get('type_offre');
        $em = $this->getDoctrine()->getManager();

        $animauxes = $em->getRepository('AnimauxBundle:Animaux')->afficheAnimauxParOffre($type_offre);

        return $this->render('animaux/Front/indexList.html.twig', array(
            'animauxes' => $animauxes,
        ));
    }

    public function afficheDescriptionAction(Request $request)
    {
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();

        $animauxes = $em->getRepository('AnimauxBundle:Animaux')->find($id);

        return $this->render('animaux/Front/indexDescription.html.twig', array(
            'animaux' => $animauxes,
        ));
    }

    public function memberPetsListAction(Request $request)
    {
        //$id_user=2;
        //$id_user=$request->get('proprietaire');
        $id_user=$this->getUser();
        $em = $this->getDoctrine()->getManager();

        $animauxes = $em->getRepository('AnimauxBundle:Animaux')->afficheAnimauxUser($id_user);

        return $this->render('animaux/Front/memberPetsList.html.twig', array(
            'animauxes' => $animauxes,
        ));
    }

    public function memberPetsListDescriptionAction(Request $request)
    {
        $id=$request->get('id');
        $em = $this->getDoctrine()->getManager();

        $animauxes = $em->getRepository('AnimauxBundle:Animaux')->find($id);

        return $this->render('animaux/Front/memberPetDescription.html.twig', array(
            'animaux' => $animauxes,
        ));
    }

    /**
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */

    public function ajouterAnimalAction(Request $request)
    {
        $animaux = new Animaux();
        $form = $this->createForm('AnimauxBundle\Form\AnimauxForm', $animaux);
        $form->handleRequest($request);
        $user=$this->getUser();

        if ($request->isMethod('Post')) {
            $animaux=$form->getData();
            $animaux->setProprietaire($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($animaux);
            $em->flush();

            return $this->redirectToRoute('animaux_User_Pets_description', array('id' => $animaux->getId()));
        }

        return $this->render('animaux/Front/FormulaireAjoutAnimal.html.twig', array(
            'animaux' => $animaux,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new animaux entity.
     *
     */
    public function newAction(Request $request)
    {
        $animaux = new Animaux();
        $form = $this->createForm('AnimauxBundle\Form\AnimauxForm', $animaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($animaux);
            $em->flush();

            return $this->redirectToRoute('animaux_show', array('id' => $animaux->getId()));
        }

        return $this->render('animaux/Back/new.html.twig', array(
            'animaux' => $animaux,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a animaux entity.
     *
     */
    public function showAction(Animaux $animaux)
    {
        $deleteForm = $this->createDeleteForm($animaux);

        return $this->render('animaux/Back/show.html.twig', array(
            'animaux' => $animaux,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing animaux entity.
     *
     */
    public function editAction(Request $request, Animaux $animaux)
    {
        $deleteForm = $this->createDeleteForm($animaux);
        $editForm = $this->createForm('AnimauxBundle\Form\AnimauxType', $animaux);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('animaux_edit', array('id' => $animaux->getId()));
        }

        return $this->render('animaux/Back/edit.html.twig', array(
            'animaux' => $animaux,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a animaux entity.
     *
     */
    public function deleteAction(Request $request, Animaux $animaux)
    {
        $form = $this->createDeleteForm($animaux);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($animaux);
            $em->flush();
        }

        return $this->redirectToRoute('animaux_index');
    }

    /**
     * Creates a form to delete a animaux entity.
     *
     * @param Animaux $animaux The animaux entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Animaux $animaux)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('animaux_delete', array('id' => $animaux->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
