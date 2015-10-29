<?php

namespace ENI\QCM\Bundle\FormateurBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ENI\QCM\Bundle\FormateurBundle\Entity\Test;
use ENI\QCM\Bundle\FormateurBundle\Entity\Section;
use ENI\QCM\Bundle\FormateurBundle\Form\TestType;
use ENI\QCM\Bundle\FormateurBundle\Models\Document;
use ENI\QCM\Bundle\FormateurBundle\Models\UploadFileMover;
use ENI\QCM\Bundle\FormateurBundle\Form\EnrichedTestType;
use Doctrine\ORM\EntityRepository;
use \ENI\QCM\Bundle\FormateurBundle\Entity\EnrichedTest;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\DateTime;
/**
 * Test controller.
 *
 * @Route("/test")
 */
class TestController extends Controller
{

    /**
     * Lists all Test entities.
     *
     * @Route("/", name="test")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EniQcmFormateurBundle:Test')->findAll();
        
        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Test entity.
     *
     * @Route("/", name="test_create")
     * @Method("POST")
     * @Template("EniQcmFormateurBundle:Test:new.html.twig")
     */
    public function createAction(Request $request)
    {
        /*
        echo 'yesss !!';
        die();
        */
        $postVariable = $request->get('eni_qcm_bundle_formateurbundle_test');
        
        $test = $this->postTestTraitement($postVariable, null);
        
        //Image upload
        if ($request->getMethod() == 'POST') {
            $this->uploadIllustrationImage($request->files->get('img'),$test->getId());
        }
        
        return $this->redirect($this->generateUrl('test_show', array('id' => $test->getId())));
        
        
        /*
        $entity = new Test();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('test_show', array('id' => $entity->getId())));
        }
       return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
         */
         
    }

    /**
     * Creates a form to create a Test entity.
     *
     * @param Test $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Test $entity)
    {
        $form = $this->createForm(new TestType(), $entity, array(
            'action' => $this->generateUrl('test_create'),
            'method' => 'POST',
        ));
        
        $form->add('themeid', 'entity', array('multiple' => true,
            'class' => 'EniQcmFormateurBundle:Theme',
            'choices' => $this->getThemeNotAssociateWithTest($entity->getId()),));
        /*
        $idTest = $entity->getId();
        $form->add('themeid', 'entity', array('multiple' => true,
            'class' => 'EniQcmFormateurBundle:Theme',
             'query_builder' => function (EntityRepository $t) {
                return $t->createQueryBuilder('t')
                        ->select('t')
                        ->from('EniQcmFormateurBundle:Section' ,'sect')
                        ->where("t.id!=sect.themeid")
                        ->andWhere("sect.themeid!= :idTest")->setParameter('idTest', $entity->getId())
                        ->orderBy('t.id', 'DESC');
            },
        ));
        */
        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Test entity.
     *
     * @Route("/new", name="test_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Test();
        //$form   = $this->createCreateForm($entity);
        
        $themeNotAssociate = $this->getThemeNotAssociateWithTest(null);

        return array(
            'entity'      => $entity,
            'themeNotAssociate' => $themeNotAssociate,
        );
        /*
        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
         * 
         */
    }

    /**
     * Finds and displays a Test entity.
     *
     * @Route("/{id}", name="test_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmFormateurBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Test entity.
     *
     * @Route("/{id}/edit", name="test_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EniQcmFormateurBundle:Test')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        //$editForm = $this->createEditForm($entity);
        $themeNotAssociate = $this->getThemeNotAssociateWithTest($id);
        $themeAssociate = $this->getThemeAssociateWithTest($id);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            //'edit_form'   => $editForm->createView(),
            'themeNotAssociate' => $themeNotAssociate,
            'themeAssociate' => $themeAssociate,
            'numberOfQuestionForAssociateTheme' => $this->getNumberOfQuestionForAssociateTheme($id),
            'delete_form' => $deleteForm->createView(),
            
                    
        );
    }
    /*
    /**
    * Creates a form to edit a Test entity.
    *
    * @param Test $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    * /
    private function createEditForm(Test $entity)
    {
        //Original
        /*
        $form = $this->createForm(new TestType(), $entity, array(
            'action' => $this->generateUrl('test_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('themeid', 'entity', array('multiple' => true,
            'class' => 'EniQcmFormateurBundle:Theme',
            'required' => false,
            'choices' => $this->getThemeNotAssociateWithTest($entity->getId()),));
        */
        
        
        
        
        /*
        $newEntity = new EnrichedTest();
        $newEntity->setTest($entity);
        $form = $this->createForm(new EnrichedTestType(), $newEntity, array(
            'action' => $this->generateUrl('test_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'data_class' => 'ENI\QCM\Bundle\FormateurBundle\Entity\EnrichedTest'
        ))*/
        //var_dump($form);
        //die();
        //$form->add('getTest()->themeid', array('data_class' => 'ENI\QCM\Bundle\FormateurBundle\Entity\Test'));
        /*
        $form->add(
            $form->create('test', 'form')
                ->add('name', 'text')
                ->add('email', 'email')
        );
         * 
         */
        //$form->add('test', 'entity', array('type' => new TestType()));
        /*
        $form->add('themeid', 'entity', array('multiple' => true,
            'class' => 'EniQcmFormateurBundle:Theme',
            'required' => false,
            'choices' => $this->getThemeNotAssociateWithTest($entity->getId()),));
        */
        /*
        $form->add('themeidassociate', 'entity', array('multiple' => true,
            'class' => 'EniQcmFormateurBundle:Theme',
            'required' => false,
            'choices' => $this->getThemeAssociateWithTest($entity->getId()),));
         * 
         * /
        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
        
    }
    */
    
    /**
     * Edits an existing Test entity.
     *
     * @Route("/{id}", name="test_update")
     * @Method("POST")
     * @Template("EniQcmFormateurBundle:Test:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $postVariable = $request->get('eni_qcm_bundle_formateurbundle_test');
        
        $test = $this->postTestTraitement($postVariable, $id);
        
        //Image upload
        if ($request->getMethod() == 'POST') {
            $this->uploadIllustrationImage($request->files->get('img'),$test->getId());
        }
        
        return $this->redirect($this->generateUrl('test_edit', array('id' => $id)));
    }
    /**
     * Deletes a Test entity.
     *
     * @Route("/{id}", name="test_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EniQcmFormateurBundle:Test')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Test entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('test'));
    }

    /**
     * Creates a form to delete a Test entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('test_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    
    
    private function getThemeNotAssociateWithTest ($idTest)
    {
        $em = $this->getDoctrine()->getManager();

        if(!is_null($idTest)){
            $query = $em->createQuery('SELECT t FROM EniQcmFormateurBundle:Theme t WHERE NOT EXISTS (SELECT t FROM EniQcmFormateurBundle:Section s WHERE s.themeid = t.id AND s.testid = :idTest) ORDER BY t.id');
            $query->setParameter('idTest', $idTest);
        }
        else{
            $query = $em->createQuery('SELECT t FROM EniQcmFormateurBundle:Theme t ');
        }
        
        $themes = $query->getResult();

        return $themes;
    }
    
    private function getThemeAssociateWithTest ($idTest)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT t FROM EniQcmFormateurBundle:Theme t WHERE EXISTS (SELECT t FROM EniQcmFormateurBundle:Section s WHERE s.themeid = t.id AND s.testid = :idTest) ORDER BY t.id');
        $query->setParameter('idTest', $idTest);
        $themes = $query->getResult();
        return $themes;
    }
    
    private function getNumberOfQuestionForAssociateTheme ($idTest)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery('SELECT s.numberofquestionsasked FROM EniQcmFormateurBundle:Section s WHERE s.testid = :idTest ORDER BY s.themeid');
        $query->setParameter('idTest', $idTest);
        $themes = $query->getResult();
        return $themes;
    }
    
    /**
     * 
     * @param type $postVariable ex: $request->get('eni_qcm_bundle_formateurbundle_test');
     * @param type $id : test id
     */
    public function postTestTraitement($postVariable, $id){
        $em = $this->getDoctrine()->getManager();
        
        if(is_null($id)){
            $test = new Test();
        }
        else{
            $test = $em->getRepository('EniQcmFormateurBundle:Test')->find($id);
            if (!$test) {
                throw $this->createNotFoundException('Unable to find Test entity.');
            }
        }
        
        
        //Construct test
        $test->setName($postVariable['name']);
        $test->setDescription($postVariable['description']);
        $test->setStep1($postVariable['step1']);
        $test->setStep2($postVariable['step2']);
        
        $minute=$postVariable['timepassing']['minute'];
        $second=$postVariable['timepassing']['second'];
        $timepassing=new \DateTime('00:'.$minute.':'.$second);
        $test->setTimepassing($timepassing);
        
        if(isset($postVariable['themeidNotAssociate'])){
            foreach($postVariable['themeidNotAssociate'] as $idTheme) {
                echo ' => ', $idTheme, '<br />';
                $theme = $em->getRepository('EniQcmFormateurBundle:Theme')->find($idTheme);
                $test->addThemeid($theme);
            }
            //Insert section
            foreach ($test->getThemeid() as $theme){
                $section= new Section();
                $section->setTestid($test);
                $section->setThemeid($theme);
                $section->setNumberofquestionsasked(0);
                $em->persist($section);
            }
        }
        $em->persist($test);
        
        //Update NumberOfQuestionsAsked
        if(isset($postVariable['themeidAssociateNumberOfQuestionAsked'])){
            foreach($postVariable['themeidAssociateNumberOfQuestionAsked'] as $idTheme => $numberOfQuestionsAsked){
                $section = $em->getRepository('EniQcmFormateurBundle:Section')->findOneBy(array('themeid' => $idTheme, 'testid' => $test->getId()));
                $section->setNumberofquestionsasked($numberOfQuestionsAsked);
                $em->persist($section);
            }
        }
        
        $em->flush();
        
        return $test;
    }


    /**
     * 
     * @param type $image ex: $request->files->get('img')
     * @param type $fileName ex: $test->getId()
     */
    private function uploadIllustrationImage($image,$fileName){
        $status = 'success';
        $uploadedURL='';
        $message='';
        if (($image instanceof UploadedFile) && ($image->getError() == '0')) {
            var_dump($image);
            if (($image->getSize() < 2000000000)) {
                $originalName = $image->getClientOriginalName();
                $name_array = explode('.', $originalName);
                $file_type = $name_array[sizeof($name_array) - 1];
                $valid_filetypes = array('jpg', 'jpeg', 'bmp', 'png');
                if (in_array(strtolower($file_type), $valid_filetypes)) {
                  //Start Uploading File
                  $document = new Document();
                  $document->setFile($image);
                  $document->setSubDirectory('public/images');
                  $document->processFile($fileName);
                  $uploadedURL=$uploadedURL = $document->getUploadDirectory() . DIRECTORY_SEPARATOR . $document->getSubDirectory() . DIRECTORY_SEPARATOR . $image->getBasename();
                } else {
                    $status = 'failed';
                    $message = 'Invalid File Type';
                }
            } else {
                $status = 'failed';
                $message = 'Size exceeds limit';
            }
        } else {
            $status = 'failed';
            $message = 'File Error';
        }
    }
}
