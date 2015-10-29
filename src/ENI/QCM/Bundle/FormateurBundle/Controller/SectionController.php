<?php

namespace ENI\QCM\Bundle\FormateurBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ENI\QCM\Bundle\FormateurBundle\Entity\Test;
use ENI\QCM\Bundle\FormateurBundle\Entity\Section;
/**
 * Test controller.
 *
 * @Route("/test")
 */
class SectionController extends Controller
{
    /**
     * Deletes a Test entity.
     *
     * @Route("/section/{idTest}/{idTheme}", name="section_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction(Request $request, $idTest, $idTheme)
    {
        echo 'start';
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EniQcmFormateurBundle:Section')->findOneBy(array('themeid' => $idTheme, 'testid' => $idTest));
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Test entity.');
        }

        $em->remove($entity);
        $em->flush();
         
        echo 'finished';
        //die();
        //$this->redirect($this->generateUrl('test_edit', array('id' => $idTest)));
        //$this->redirect($this->generateUrl('test_edit', array('id' => $idTest)));
        return $this->redirectToRoute('test_edit',array('id' => $idTest));
        //return $this->redirect($this->generateUrl('test'));
    }
}
