<?php

namespace EvaluationsBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EvaluationsBundle\Entity\Area;
use EvaluationsBundle\Form\AreaType;

class PayrollQualificationsController extends Controller
{
    public function showPayrollQualificationsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $testTaken = $em->getRepository('EvaluationsBundle:TestTaken')->findBy(array('idTest'=>$id));
        $userAnswer = $em->getRepository('EvaluationsBundle:UserAnswer')->findBy(array('idTest'=>$id));

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT u
                                    FROM EvaluationsBundle:TestTaken c
                                    JOIN EvaluationsBundle:UserSystem u WITH u.idUser = c.idUser");

        $userSystem = $query->getResult();

        return $this->render('EvaluationsBundle:TestForm:payrollQualifications.html.twig', array(
            'testTaken' => $testTaken,
            'userAnswewer'=>$userAnswer,
            'userSystem'=>$userSystem
        ));

    }

}