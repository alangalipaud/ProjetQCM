<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ENI\QCM\Bundle\StagiaireBundle\Entity\Registration;
use ENI\QCM\Bundle\StagiaireBundle\Form\RegistrationType;

/**
 * Registration controller.
 *
 * @Route("/registration")
 */
class RegistrationController extends Controller
{

    /**
     * Lists all Registration entities.
     *
     * @Route("/", name="registration")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EniQcmStagiaireBundle:Registration')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Registration entity.
     *
     * @Route("/", name="registration_create")
     * @Method("POST")
     * @Template("EniQcmStagiaireBundle:Registration:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Registration();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('registration_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Registration entity.
     *
     * @param Registration $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Registration $entity)
    {
        $form = $this->createForm(new RegistrationType(), $entity, array(
            'action' => $this->generateUrl('registration_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Registration entity.
     *
     * @Route("/new", name="registration_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Registration();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Registration entity.
     *
     * @Route("/{id}", name="registration_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmStagiaireBundle:Registration')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registration entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Registration entity.
     *
     * @Route("/{id}/edit", name="registration_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmStagiaireBundle:Registration')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registration entity.');
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
    * Creates a form to edit a Registration entity.
    *
    * @param Registration $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Registration $entity)
    {
        $form = $this->createForm(new RegistrationType(), $entity, array(
            'action' => $this->generateUrl('registration_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Registration entity.
     *
     * @Route("/{id}", name="registration_update")
     * @Method("PUT")
     * @Template("EniQcmStagiaireBundle:Registration:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmStagiaireBundle:Registration')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Registration entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('registration_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Registration entity.
     *
     * @Route("/{id}", name="registration_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EniQcmStagiaireBundle:Registration')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Registration entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('registration'));
    }

    /**
     * Creates a form to delete a Registration entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('registration_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
