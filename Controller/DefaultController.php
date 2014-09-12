<?php

namespace BiberLtd\Bundle\ExceptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BiberLtdBundlesExceptionBundle:Default:index.html.twig', array('name' => $name));
    }
}
