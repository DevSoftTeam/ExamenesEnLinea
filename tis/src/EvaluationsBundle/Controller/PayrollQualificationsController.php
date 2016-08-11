<?php

namespace EvaluationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PayrollQualificationsController extends Controller
{
    public function showPayrollQualificationsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $testsTaken = $em->getRepository('EvaluationsBundle:TestTaken')->findBy(array('idTest' => $id));
//        $testQuestions = $em->getRepository('EvaluationsBundle:TestQuestion')->findBy(array('idTest' => $id));

        $query = $em->createQuery("SELECT question
                                    FROM EvaluationsBundle:TestQuestion question
                                    WHERE question.idTest = ?1 ORDER BY question.idQuestion")->setParameter('1', $id);
        $testQuestions = $query->getResult();

        $query = $em->createQuery( "SELECT  answer
                                    FROM EvaluationsBundle:UserAnswer answer
                                    JOIN EvaluationsBundle:TestQuestion question
                                    WITH question.idQuestion = answer.idQuestion
                                    WHERE answer.idTest = ?1 ORDER BY question.idQuestion")->setParameter('1',$id);
        $answersDetails = $query -> getResult();

        return $this->render('EvaluationsBundle:TestForm:payrollQualifications.html.twig', array(
            'testsTaken' => $testsTaken,
            'answers'=> $answersDetails,
            'questions'=>$testQuestions,
            'idTest'=>$id
        ));

    }

}