<?php

namespace EvaluationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EvaluationsBundle:Default:index.html.twig');
    }
}
