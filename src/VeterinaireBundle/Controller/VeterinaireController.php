<?php

namespace VeterinaireBundle\Controller;

use VeterinaireBundle\Entity\Veterinaire;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Veterinaire controller.
 *
 */
class VeterinaireController extends Controller
{
    /**
     * Lists all veterinaire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $veterinaires = $em->getRepository('VeterinaireBundle:Veterinaire')->findAll();

        return $this->render('veterinaire/index.html.twig', array(
            'veterinaires' => $veterinaires,
        ));
    }

    public function index_backAction()
    {
        $em = $this->getDoctrine()->getManager();

        $veterinaires = $em->getRepository('VeterinaireBundle:Veterinaire')->findAll();

        return $this->render('veterinaire/index_back.html.twig', array(
            'veterinaires' => $veterinaires,
        ));
    }

    /**
     * Creates a new veterinaire entity.
     *
     */
    public function newAction(Request $request)
    {
        $veterinaire = new Veterinaire();
        $form = $this->createForm('VeterinaireBundle\Form\VeterinaireType', $veterinaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($veterinaire);
            $em->flush();

            return $this->redirectToRoute('veterinaire_show_back', array('id' => $veterinaire->getId()));
        }

        return $this->render('veterinaire/new.html.twig', array(
            'veterinaire' => $veterinaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a veterinaire entity.
     *
     */
    public function showAction(Veterinaire $veterinaire)
    {
        $deleteForm = $this->createDeleteForm($veterinaire);

        return $this->render('veterinaire/show.html.twig', array(
            'veterinaire' => $veterinaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function show_backAction(Veterinaire $veterinaire)
    {
        $deleteForm = $this->createDeleteForm($veterinaire);

        return $this->render('veterinaire/show_back.html.twig', array(
            'veterinaire' => $veterinaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing veterinaire entity.
     *
     */
    public function editAction(Request $request, Veterinaire $veterinaire)
    {
        $deleteForm = $this->createDeleteForm($veterinaire);
        $editForm = $this->createForm('VeterinaireBundle\Form\VeterinaireType', $veterinaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('veterinaire_edit', array('id' => $veterinaire->getId()));
        }

        return $this->render('veterinaire/edit.html.twig', array(
            'veterinaire' => $veterinaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a veterinaire entity.
     *
     */
    public function deleteAction(Request $request, Veterinaire $veterinaire)
    {
        $form = $this->createDeleteForm($veterinaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($veterinaire);
            $em->flush();
        }

        return $this->redirectToRoute('veterinaire_index_back');
    }

    /**
     * Creates a form to delete a veterinaire entity.
     *
     * @param Veterinaire $veterinaire The veterinaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Veterinaire $veterinaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('veterinaire_delete', array('id' => $veterinaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
