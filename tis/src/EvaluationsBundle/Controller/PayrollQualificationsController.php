<?php

namespace EvaluationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class PayrollQualificationsController extends Controller
{
    public function showPayrollQualificationsAction($id) {
        $em = $this->getDoctrine()->getManager();
        $testsTaken = $em->getRepository('EvaluationsBundle:TestTaken')->findBy(array('idTest' => $id));
        $testQuestions = $em->getRepository('EvaluationsBundle:TestQuestion')->findBy(array('idTest' => $id));

//        $query = $em->createQuery("SELECT u
//                                    FROM EvaluationsBundle:TestTaken c
//                                    JOIN EvaluationsBundle:UserSystem u
//                                    WITH u.idUser = c.idUser");

        $query = $em->createQuery( "SELECT  answer
                                    FROM EvaluationsBundle:UserAnswer answer
                                    JOIN EvaluationsBundle:TestQuestion question
                                    WITH question.idQuestion = answer.idQuestion
                                    WHERE answer.idTest = ?1")->setParameter('1',$id);
        $answersDetails = $query -> getResult();

        return $this->render('EvaluationsBundle:TestForm:payrollQualifications.html.twig', array(
            'testsTaken' => $testsTaken,
            'answers'=> $answersDetails,
            'questions'=>$testQuestions,
            'idTest'=>$id
        ));

    }

}