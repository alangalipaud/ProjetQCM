<?php

namespace ENI\QCM\Bundle\StagiaireBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /*return $this->render('EniQcmStagiaireBundle:Login:index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
            ));*/
        return $this->forward('EniQcmStagiaireBundle:Currenttest:index');
    }
}
