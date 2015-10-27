<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ENI\QCM\Bundle\StagiaireBundle\Entity\Currenttest;
use ENI\QCM\Bundle\StagiaireBundle\Form\CurrenttestType;

/**
 * Currenttest controller.
 *
 * @Route("/currenttest")
 */
class CurrenttestController extends Controller
{
    
    /**
     * Lists all Currenttest entities.
     *
     * @Route("/", name="currenttest")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $currentTests = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->findAll();
        foreach ($currentTests as &$currentTest) {
            $entities[] = array('currentTest' => $currentTest , 'numberofquestions' => $this->sumQuestionNumber($currentTest->getRegistrationid()->getTestid()));
        }
        
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Currenttest entity.
     *
     * @Route("/", name="currenttest_create")
     * @Method("POST")
     * @Template("EniQcmStagiaireBundle:Currenttest:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Currenttest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('currenttest_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Currenttest entity.
     *
     * @param Currenttest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Currenttest $entity)
    {
        $form = $this->createForm(new CurrenttestType(), $entity, array(
            'action' => $this->generateUrl('currenttest_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Currenttest entity.
     *
     * @Route("/new", name="currenttest_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Currenttest();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Currenttest entity.
     *
     * @Route("/{id}", name="user_currenttest_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($id);
        $_SESSION['timeOfQuestionShow'] = new \DateTime('NOW');
        $_SESSION['currentTest'] = $id;
        $issueRaffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($entity->getIssueRafflingId()); 

        $answers = $em->getRepository('EniQcmStagiaireBundle:Answer')->findBy(array('questionid' => $issueRaffling->getQuestionId()));
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Currenttest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'answers'     => $answers,
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Finds and displays a Currenttest entity.
     *
     * @Route("/{id}", name="user_currenttest_post")
     * @Method("POST")
     * @Template()
     */
    public function writeAction(Request $request)
    {
        $answers = $request->get('answers');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($_SESSION['currentTest']);
        $issueRaffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($entity->getIssueRafflingId());
        foreach ($answers as &$answerId){
            $answer = $em->getRepository('EniQcmStagiaireBundle:Answer')->find($answerId);
            $issueRaffling->addAnswerid($answer);
        }
        $em->flush();
        return $this->render('EniQcmStagiaireBundle:Currenttest:return.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
     * Displays a form to edit an existing Currenttest entity.
     *
     * @Route("/{id}/edit", name="currenttest_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Currenttest entity.');
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
    * Creates a form to edit a Currenttest entity.
    *
    * @param Currenttest $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Currenttest $entity)
    {
        $form = $this->createForm(new CurrenttestType(), $entity, array(
            'action' => $this->generateUrl('currenttest_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Currenttest entity.
     *
     * @Route("/{id}", name="currenttest_update")
     * @Method("PUT")
     * @Template("EniQcmStagiaireBundle:Currenttest:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Currenttest entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('currenttest_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Currenttest entity.
     *
     * @Route("/{id}", name="currenttest_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Currenttest entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('currenttest'));
    }

    /**
     * Creates a form to delete a Currenttest entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('currenttest_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    private function sumQuestionNumber($testId) {

        $queryScore = $this->getDoctrine()
            ->getRepository('EniQcmStagiaireBundle:Section');

        $queryAvgScore = $queryScore->createQueryBuilder('g')
            ->select("sum(g.numberofquestionsasked)")
            ->where('g.testid = :testid')
            ->setParameter('testid', $testId)
            ->getQuery();

        $avgScore = $queryAvgScore->getResult();

        $result = $avgScore;

        return $result[0][1];
    }
}
