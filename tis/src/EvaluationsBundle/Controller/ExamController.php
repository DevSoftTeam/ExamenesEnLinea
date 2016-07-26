<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EvaluationsBundle\Entity\Test;
use EvaluationsBundle\Entity\TestQuestion;
use EvaluationsBundle\Form\TestType;
use EvaluationsBundle\Entity\AnswerElement;
use Symfony\Component\Validator\Constraints\Time;
/**
 * Test controller.
 *
 */
class ExamController extends Controller
{
    /**
     * Lists all Test entities.
     *
     */
    public function formAction($idTest)
    { 
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('EvaluationsBundle:Test')->find($idTest);
        //$testQuestions = $em->getRepository('EvaluationsBundle:TestQuestion')->findBy(array('idTest'=>$test));
        //$questions = $em->getRepository('EvaluationsBundle:Question')->findBy()array('idQuestion');
        $result = $em->createQueryBuilder();
        $questions = $result->select(array('q'))
            ->from('EvaluationsBundle:Question', 'q')
            ->innerJoin('EvaluationsBundle:TestQuestion','t', 'WITH', 't.idQuestion = q.idQuestion and t.idTest = :idT')
            ->where('t.idTest = '.$idTest)
            ->setParameter('idT' , $test->getIdTest())
            ->getQuery()
            ->getResult();

        $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$questions[3]));
        /**foreach ($questions as $question) {
            $answersQ = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
            array_push($answers, $answersQ);
        }**/
        return $this->render('EvaluationsBundle:TestForm:test.html.twig', array(
            'test' => $test,
            'questions' => $questions,
            'answers' => $answers,
        ));
    }
    public function newAction(Request $request)
    {
        $test = new Test();
        $form = $this->createForm('EvaluationsBundle\Form\TestType', $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
        }

        return $this->render('test/new.html.twig', array(
            'test' => $test,
            'form' => $form->createView(),
        ));
    }

}
