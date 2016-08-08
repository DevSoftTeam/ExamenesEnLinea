<?php

namespace EvaluationsBundle\Controller;


class PayrollQualificationsController
{
    public function showPayrollQualificationsAction($idTest) {
        $em = $this->getDoctrine()->getManager();
        $testTaken = $em->getRepository('EvaluationsBundle:TestTaken')->findBy(array('idTest'=>$idTest));
        $userAnswer = $em->getRepository('EvaluationsBundle:UserAnswer')->findBy(array('idTest'=>$idTest));

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