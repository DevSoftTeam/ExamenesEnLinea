<?php

namespace EvaluationsBundle\Controller;
 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EvaluationsBundle\Entity\Question;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class trueFalseQuestionController extends Controller
{
	 public function newAction()
    {

    	$em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository('EvaluationsBundle:Area')->findAll();
       return $this->render('EvaluationsBundle:Question:trueFalseQuestion.html.twig',array('areas'=>$areas));
    	
    }

}