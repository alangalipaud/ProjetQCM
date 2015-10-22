<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ENI\QCM\Bundle\StagiaireBundle\Entity\Issueraffling;
use ENI\QCM\Bundle\StagiaireBundle\Form\IssuerafflingType;

/**
 * Issueraffling controller.
 *
 * @Route("/issueraffling")
 */
class IssuerafflingController extends Controller
{

    /**
     * Lists all Issueraffling entities.
     *
     * @Route("/", name="issueraffling")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Issueraffling entity.
     *
     * @Route("/", name="issueraffling_create")
     * @Method("POST")
     * @Template("EniQcmStagiaireBundle:Issueraffling:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Issueraffling();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('issueraffling_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Issueraffling entity.
     *
     * @param Issueraffling $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Issueraffling $entity)
    {
        $form = $this->createForm(new IssuerafflingType(), $entity, array(
            'action' => $this->generateUrl('issueraffling_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Issueraffling entity.
     *
     * @Route("/new", name="issueraffling_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Issueraffling();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Issueraffling entity.
     *
     * @Route("/{id}", name="issueraffling_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Issueraffling entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Issueraffling entity.
     *
     * @Route("/{id}/edit", name="issueraffling_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Issueraffling entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Issueraffling entity.
    *
    * @param Issueraffling $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Issueraffling $entity)
    {
        $form = $this->createForm(new IssuerafflingType(), $entity, array(
            'action' => $this->generateUrl('issueraffling_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Issueraffling entity.
     *
     * @Route("/{id}", name="issueraffling_update")
     * @Method("PUT")
     * @Template("EniQcmStagiaireBundle:Issueraffling:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Issueraffling entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('issueraffling_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Issueraffling entity.
     *
     * @Route("/{id}", name="issueraffling_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Issueraffling entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('issueraffling'));
    }

    /**
     * Creates a form to delete a Issueraffling entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('issueraffling_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
