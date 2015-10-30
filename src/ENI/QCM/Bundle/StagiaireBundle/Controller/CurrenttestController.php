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
        if(!isset($_SESSION['currentTest'])){
            $_SESSION['currentTest'] = 0;
            $_SESSION['finishedRound'] = 0;
        }
        if($_SESSION['currentTest'] != $id ){
            $_SESSION['currentTest'] = $id;
            $_SESSION['indexOfQuestion'] = 1;
            $_SESSION['finishedRound'] = 0;
            $this->container->get('request')->getSession()->set('numberOfQuestions',$this->sumQuestionNumber($entity->getRegistrationid()->getTestid()));
        }
        
        $this->container->get('request')->getSession()->set('indexOfQuestion', $_SESSION['indexOfQuestion']);
        $this->container->get('request')->getSession()->set('finishedRound', $_SESSION['finishedRound']);
        $allissueraffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')
                ->findBy(array('registrationid' => $entity->getRegistrationid()));
        $_SESSION['Issueraffling']=$allissueraffling[$_SESSION['indexOfQuestion']-1];
        $issueRaffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($_SESSION['Issueraffling']);
        $answers = $em->getRepository('EniQcmStagiaireBundle:Answer')->findBy(array('questionid' => $issueRaffling->getQuestionId()));
        foreach ($answers as $answer){
            $result = $em->getRepository('EniQcmStagiaireBundle:Answergiven')->findBy(array('issuerafflingid' => $_SESSION['Issueraffling'], 'answerid' => $answer));
            if($result != null){
                $checked = true;
            }
            else{
                $checked = false;
            }  
            $returnAnswers[] = array('answer' => $answer, 'ischecked' => $checked);
        }
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Currenttest entity.');
        }
        
            /*
            * Changement of restantTime
            */
           $time = new \DateTime('NOW');
           $timeOfQuestionStart = $_SESSION['timeOfQuestionShow'];
           $dif = $time->diff($timeOfQuestionStart);
           $restanttime = new \DateTime($entity->getCurrenttime()->add($dif)->format('H:i:s'));
           $entity->setCurrenttime($restanttime);
           $em->flush();

        return array(
            'entity'      => $entity,
            'allanswers'     => $returnAnswers,
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
        //$_SESSION['timeOfQuestionShow'] = new \DateTime('NOW');
        $answers = $request->get('answers');
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($_SESSION['currentTest']);
        $issueRaffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($_SESSION['Issueraffling']);
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
        
        /*
         * Changement of restantTime
         */
        $time = new \DateTime('NOW');
        $timeOfQuestionStart = $_SESSION['timeOfQuestionShow'];
        $dif = $time->diff($timeOfQuestionStart);
        $restanttime = new \DateTime($entity->getCurrenttime()->add($dif)->format('H:i:s'));
        $entity->setCurrenttime($restanttime);
        $em->flush();
        
        
        /*
         * Recuperation des autres questions
         */
        $othersissueraffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')
                ->findBy(array('registrationid' => $issueRaffling->getRegistrationid()));
        
        if($request->get('action') == 'Previous'){
            if($_SESSION['indexOfQuestion'] > 1){
            $_SESSION['indexOfQuestion'] = $_SESSION['indexOfQuestion'] - 1;
            $nextissueraffling = $othersissueraffling[$_SESSION['indexOfQuestion']-1];
            $entity->setIssueRafflingId($nextissueraffling);
            $em->flush();
            }
            return $this->forward('EniQcmStagiaireBundle:Currenttest:show', array('id' => $_SESSION['currentTest']));
        }
        if($request->get('action') == 'Next'){
            if($_SESSION['indexOfQuestion'] < sizeof($othersissueraffling)){
            $_SESSION['indexOfQuestion'] = $_SESSION['indexOfQuestion'] + 1;
            $nextissueraffling = $othersissueraffling[$_SESSION['indexOfQuestion']-1];
            $entity->setIssueRafflingId($nextissueraffling);
            $em->flush();
            }
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
        $_SESSION['timeOfQuestionShow'] = new \DateTime('NOW');
        $_SESSION['finishedRound'] = 1;
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
        
            /*
            * Changement of restantTime
            */
           $time = new \DateTime('NOW');
           $timeOfQuestionStart = $_SESSION['timeOfQuestionShow'];
           $dif = $time->diff($timeOfQuestionStart);
           $restanttime = new \DateTime($currentTest->getCurrenttime()->add($dif)->format('H:i:s'));
           $currentTest->setCurrenttime($restanttime);
           $em->flush();
        
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
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($_SESSION['currentTest']);
        
        if($request->getMethod() == "GET"){
            $_SESSION['indexOfQuestion'] = $id;
            
            $allissueraffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')
                    ->findBy(array('registrationid' => $entity->getRegistrationid()));
                $_SESSION['Issueraffling']=$allissueraffling[$_SESSION['indexOfQuestion']-1];
                $issueRaffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($_SESSION['Issueraffling']);
            $entity->setIssuerafflingid($issueRaffling);
            $em->flush();
            /*
            * Changement of restantTime
            */
           $time = new \DateTime('NOW');
           $timeOfQuestionStart = $_SESSION['timeOfQuestionShow'];
           $dif = $time->diff($timeOfQuestionStart);
           $restanttime = new \DateTime($entity->getCurrenttime()->add($dif)->format('H:i:s'));
           $entity->setCurrenttime($restanttime);
           $em->flush();
           
        }
        else{
            /*** Enregistrement des données ***/
            /*$allissueraffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')
                ->findBy(array('registrationid' => $entity->getRegistrationid()));
            $_SESSION['Issueraffling']=$allissueraffling[$_SESSION['indexOfQuestion']-1];*/
            $issueRaffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->find($_SESSION['Issueraffling']);
            $answers = $request->get('answers');
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
            * Changement of restantTime
            */
           $time = new \DateTime('NOW');
           $timeOfQuestionStart = $_SESSION['timeOfQuestionShow'];
           $dif = $time->diff($timeOfQuestionStart);
           $restanttime = new \DateTime($entity->getCurrenttime()->add($dif)->format('H:i:s'));
           $entity->setCurrenttime($restanttime);
           $em->flush();

            /*** Passage à la question suivante ***/
            $othersissueraffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')
                    ->findBy(array('registrationid' => $issueRaffling->getRegistrationid()));
            if($request->get('action') == 'Previous'){
                if($_SESSION['indexOfQuestion'] > 1){
                $_SESSION['indexOfQuestion'] = $_SESSION['indexOfQuestion'] - 1;
                $nextissueraffling = $othersissueraffling[$_SESSION['indexOfQuestion']-1];
                $entity->setIssueRafflingId($nextissueraffling);
                $em->flush();
                }
            }
            if($request->get('action') == 'Next'){
                if($_SESSION['indexOfQuestion'] < sizeof($othersissueraffling)){
                $_SESSION['indexOfQuestion'] = $_SESSION['indexOfQuestion'] + 1;
                $nextissueraffling = $othersissueraffling[$_SESSION['indexOfQuestion']-1];
                $entity->setIssueRafflingId($nextissueraffling);
                $em->flush();
                }
            }
            if($request->get('action') == 'Synthese'){
                return $this->forward('EniQcmStagiaireBundle:Currenttest:synthese', array('id' => $_SESSION['currentTest']));
            }
        }
        return $this->forward('EniQcmStagiaireBundle:Currenttest:show', array('id' => $_SESSION['currentTest']));
    }
    
    /**
     * Finds and displays a Currenttest Synthese.
     *
     * @Route("/validation/{id}", name="user_currenttest_valid")
     * @Method("GET")
     * @Template()
     */
    public function exitTestAction($id){
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($id);
        $test->setIscompleted(true);
        $em->flush();
        
        return $this->forward('EniQcmStagiaireBundle:Currenttest:index');
    }
    
    /**
     * Finds and displays a Currenttest Synthese.
     *
     * @Route("/results/{id}", name="user_currenttest_results")
     * @Method("GET")
     * @Template()
     */
    public function resultAction($id){$em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('EniQcmStagiaireBundle:Currenttest')->find($id);
        $allissueraffling = $em->getRepository('EniQcmStagiaireBundle:Issueraffling')->findBy(array('registrationid' => $test->getRegistrationid()));
        //var_dump($allissueraffling);
        foreach($allissueraffling as $anissueraffling){
            $allQuestions[] = $em->getRepository('EniQcmStagiaireBundle:Question')->find($anissueraffling->getQuestionid());
            $allAnswersGiven[] = $em->getRepository('EniQcmStagiaireBundle:Answergiven')->findBy(array('issuerafflingid' => $anissueraffling));
            $allGoodAnswers[] = $em->getRepository('EniQcmStagiaireBundle:Answer')->findBy(array('questionid' => $anissueraffling->getQuestionid(), 'isvalid' => 1));
        }
        $allThemes = array();
        for($i=0; $i< sizeof($allQuestions); $i++){
            $newTheme = $em->getRepository('EniQcmStagiaireBundle:Theme')->find( $allQuestions[$i]->getThemeid() );
            if(!in_array($newTheme, $allThemes)){
                $allThemes[]= $newTheme;
            }
        }
        
        foreach($allThemes as $theme){
            $nbOfQuestions = 0;
            $nbOfGoodAnswers = 0;
            for($i=0; $i< sizeof($allQuestions); $i++) {
                $goodAnswersByQuestion =  array();
                $answersGivenByQuestion = array();
                if($allQuestions[$i]->getThemeId() == $theme){
                    $nbOfQuestions++;
                
                
                foreach ($allGoodAnswers as $gaPart1){
                    foreach ($gaPart1 as $aGoodAnswer){
                        if($aGoodAnswer->getQuestionid() == $allQuestions[$i] ){
                        $goodAnswersByQuestion[] = $aGoodAnswer->getId();
                        }
                    }
                }
                foreach ($allAnswersGiven as $agPart1){
                    foreach ($agPart1 as $anAnswerGiven){
                        if($anAnswerGiven->getIssuerafflingid()->getQuestionid() == $allQuestions[$i]){
                        $answersGivenByQuestion[] = $anAnswerGiven->getAnswerid()->getId();
                        }
                    }
                }
                /*
                for($j=0; $j< sizeof($allGoodAnswers); $j++){
                    if($allGoodAnswers[$j]->getQuestionid() == $allQuestions[$i]){
                        $goodAnswersByQuestion[] = $allGoodAnswers[$j]->id;
                    }
                }
                for($k=0; $k< sizeof($allAnswersGiven); $k++){
                    if($allAnswersGiven[$k]->getIssuerafflingid()->getQuestionid() == $allQuestions[$i]){
                        $answersGivenByQuestion[] = $allAnswersGiven[$k]->getAnswerid()->id;
                    }
                }
                */ 
                if($goodAnswersByQuestion == $answersGivenByQuestion){
                    $nbOfGoodAnswers++;
                }
                }
                unset($goodAnswersByQuestion);
                unset($answersGivenByQuestion);
            }
            $entities[] = ['theme' => $theme, 'nbOfQuestions' => $nbOfQuestions, 'nbOfGoodAnswers' => $nbOfGoodAnswers];
        }
        //var_dump($entities);
        return array(
            'entities'   => $entities,
            'test'   => $test,
        );
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
