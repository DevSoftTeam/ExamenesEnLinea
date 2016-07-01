<?php

namespace EvaluationsBundle\Controller;


class QuestionSelectorController extends Controller
{
    public function indexAction($area)
    {
        return $this->render('EvaluationsBundle:questionSelector:index.html.twig', array('areaname'=>'introduccion a la programacion'));
    }
}