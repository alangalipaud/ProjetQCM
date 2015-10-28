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
        if($_SESSION['currentTest'] != $id){
            $_SESSION['currentTest'] = $id;
            $_SESSION['indexOfQuestion'] = 1;
            $this->container->get('request')->getSession()->set('numberOfQuestions',$this->sumQuestionNumber($entity->getRegistrationid()->getTestid()));
        }
        $this->container->get('request')->getSession()->set('indexOfQuestion', $_SESSION['indexOfQuestion']);
        $allissueraffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')
                ->findBy(array('registrationid' => $entity->getRegistrationid()));
        $_SESSION['Issueraffling']=$allissueraffling[$_SESSION['indexOfQuestion']-1];
        $issueRaffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($_SESSION['Issueraffling']);
        $answers = $em->getRepository('EniQcmStagiaireBundle:Answer')->findBy(array('questionid' => $issueRaffling->getQuestionId()));
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Currenttest entity.');
        }

        return array(
            'entity'      => $entity,
            'answers'     => $answers,
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
        var_dump($answers);
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($_SESSION['currentTest']);
        $issueRaffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($entity->getIssueRafflingId());
        $previousanswersgiven = $em->getRepository('EniQcmStagiaireBundle:Answergiven')->findBy(array('issuerafflingid' => $issueRaffling));
        foreach($previousanswersgiven as $previousanswergiven){
            $em->remove($previousanswergiven);
        }
        $em->flush();
        if($answers != null){
            foreach ($answers as &$answerId){
            $answer = $em->getRepository('EniQcmStagiaireBundle:Answer')->find($answerId);
            $answergiven = new \ENI\QCM\Bundle\StagiaireBundle\Entity\Answergiven();
            $answergiven->setIssuerafflingid($issueRaffling);
            $answergiven->setAnswerid($answer);
            $em->persist($answergiven);
        }
        }
        if($request->get('isMarqueted') == 'on'){
            $issueRaffling->setIsmarqueted(true);
        }
        else
        {
            $issueRaffling->setIsmarqueted(false);
        }
        $em->flush();
        
        /*
         * Passage à la question Suivante
         */
        $othersissueraffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')
                ->findBy(array('registrationid' => $issueRaffling->getRegistrationid()));
        if($_SESSION['indexOfQuestion'] < sizeof($othersissueraffling)){
            $_SESSION['indexOfQuestion'] = $_SESSION['indexOfQuestion'] + 1;
            $nextissueraffling = $othersissueraffling[$_SESSION['indexOfQuestion']-1];
            $entity->setIssueRafflingId($nextissueraffling);
            $em->flush();
        }
        
        /*
         * Revient sur une demande de question
         */
        /*return $this->render('EniQcmStagiaireBundle:Currenttest:return.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));*/
        if($request->get('action') == 'Next'){
            return $this->forward('EniQcmStagiaireBundle:Currenttest:show', array('id' => $_SESSION['currentTest']));
        }
        if($request->get('action') == 'Synthese'){
            return $this->forward('EniQcmStagiaireBundle:Currenttest:synthese', array('id' => $_SESSION['currentTest']));
        }
    }
    
    /**
     * Finds and displays a Currenttest Synthese.
     *
     * @Route("/synthese/{id}", name="user_currenttest_show_synthese")
     * @Method("GET")
     * @Template()
     */
    public function syntheseAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $currentTest = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($id);
        $issuerafflings = $em->getRepository('EniQcmStagiaireBundle:IssueRaffling')->findBy(array('registrationid' => $currentTest->getRegistrationId()));
        
        $allissuerafflings = null;
        $numberOfQuestionsAnswered = 0;
        
        foreach ($issuerafflings as $issueraffling){
            $answergiven = $em->getRepository('EniQcmStagiaireBundle:Answergiven')->findBy(array('issuerafflingid' => $issueraffling));
            if($answergiven == null){
                $statementofanswer = "noanswered";
                $classstatement = "btn-danger";
            }
            else{
                $statementofanswer = "answered";
                $classstatement = "btn-success";
                $numberOfQuestionsAnswered++;
            }
            if($issueraffling->getIsMarqueted() == true){
                $statementofanswer = "marqueted";
                $classstatement = "btn-warning";
            }
            $allissuerafflings[] = array('issueraffing' => $issueraffling, 'statementofanswer' => $statementofanswer, 'classstatement' => $classstatement);
        }
        
        return array(
            'currenttest'   => $currentTest,
            'allissuerafflings' => $allissuerafflings,
            'numberOfQuestionsAnswered' => $numberOfQuestionsAnswered,
        );
    }
    
    /**
     * Finds and displays a Currenttest Synthese.
     *
     * @Route("/question/{id}", name="user_currenttest_show_question")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function selectQuestionAction(Request $request, $id)
    {
        var_dump($request->getMethod());
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($_SESSION['currentTest']);
        $issueRaffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($entity->getIssueRafflingId());
        
        if($request->getMethod() == "GET"){
            $_SESSION['indexOfQuestion'] = $id;
        }
        else{
            /*** Enregistrement des données ***/
            $answers = $request->get('answers');
            var_dump($answers);
            $previousanswersgiven = $em->getRepository('EniQcmStagiaireBundle:Answergiven')->findBy(array('issuerafflingid' => $issueRaffling));
            foreach($previousanswersgiven as $previousanswergiven){
                $em->remove($previousanswergiven);

            $em->flush();
            if($answers != null){
                foreach ($answers as &$answerId){
                $answer = $em->getRepository('EniQcmStagiaireBundle:Answer')->find($answerId);
                $answergiven = new \ENI\QCM\Bundle\StagiaireBundle\Entity\Answergiven();
                $answergiven->setIssuerafflingid($issueRaffling);
                $answergiven->setAnswerid($answer);
                $em->persist($answergiven);
            }
            }
            if($request->get('isMarqueted') == 'on'){
                $issueRaffling->setIsmarqueted(true);
            }
            else
            {
                $issueRaffling->setIsmarqueted(false);
            }
            $em->flush();
            }

            /*** Passage à la question suivante ***/
            $othersissueraffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')
                    ->findBy(array('registrationid' => $issueRaffling->getRegistrationid()));
            if($_SESSION['indexOfQuestion'] < sizeof($othersissueraffling) && $_SESSION['indexOfQuestion']>0){
                $_SESSION['indexOfQuestion']++;
                $nextissueraffling = $othersissueraffling[$_SESSION['indexOfQuestion']-1];
                $entity->setIssueRafflingId($nextissueraffling);
                $em->flush();
            }
        }
        if($request->get('action') == 'Synthese'){
            return $this->forward('EniQcmStagiaireBundle:Currenttest:synthese', array('id' => $_SESSION['currentTest']));
        }
        return $this->forward('EniQcmStagiaireBundle:Currenttest:show', array('id' => $_SESSION['currentTest']));
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
