<?php

namespace EvaluationsBundle\Controller;


class PayrollQualificationsController
{
    public function showPayrollQualificationsAction($idTest) {
        $em = $this->getDoctrine()->getManager();
        $testTakens = $em->getRepository('EvaluationsBundle:TestTaken')->findBy(array('idTest'=>$idTest));
        $userAnswer = $em->getRepository('EvaluationsBundle:UserAnswer')->findBy(array('idTest'=>$idTest));
        return $this->render('EvaluationsBundle:TestForm:payrollQualifications.html.twig', array(
            'testTaken' => $testTakens,
            'userAnswewer'=>$userAnswer
        ));

    }

}