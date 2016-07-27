<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EvaluationsBundle\Entity\Test;
use EvaluationsBundle\Entity\TestTaken;
use EvaluationsBundle\Entity\AnswerElement;
use EvaluationsBundle\Entity\UserAnswer;

class ExamController extends Controller
{
    public function formAction($idTest)
    { 
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('EvaluationsBundle:Test')->find($idTest);
        $result = $em->createQueryBuilder();
        $questions = $result->select(array('q'))
            ->from('EvaluationsBundle:Question', 'q')
            ->innerJoin('EvaluationsBundle:TestQuestion','t', 'WITH', 't.idQuestion = q.idQuestion and t.idTest = :idT')
            ->where('t.idTest = '.$idTest)
            ->setParameter('idT' , $test->getIdTest())
            ->getQuery()
            ->getResult();

        $data = array();
        foreach ($questions as $question) {
            $resp = array();
            $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion' =>$question));
            if($question->getIdQuestion()==7 && count($answers)>2){
                $columA = array();
                $columB = array();
                for ($i=0; $i < count($answers)-1; $i=$i+2) { 
                    array_push($columA,$answers[$i]);
                    array_push($columB,$answers[$i+1]);
                }
                shuffle($columB);
                $answers = array_merge($columA,$columB);
            }else{
                shuffle($answers);
            }
            $resp['question'] = $question;
            $resp['answers'] = $answers;
            $data[] = $resp;
        }
        return $this->render('EvaluationsBundle:TestForm:test.html.twig', array(
            'test' => $test,
            'data' => $data,
        ));
    }
    public function saveExamAction($idTest,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('EvaluationsBundle:Test')->find($idTest);
        $user = $this->getUser();
        // save test taken
        $testTaken = new TestTaken();
        $testTaken->setIdTest($test);
        $testTaken->setIdUser($user);
        $em->persist($testTaken);
        // save answers user
        $i = 1;
        $idQuestion = $request->get('idQuestion'.$i);
        while($idQuestion!=""){
            $question = $em->getRepository('EvaluationsBundle:Question')->find($idQuestion);
            $userAnswer = new UserAnswer();
            $userAnswer->setIdQuestion($question);
            $userAnswer->setIdUser($user);
            $userAnswer->setIdTest($test);

            switch ($idQuestion) {
                case 1:
                    $parrafo = $request->get('answer'.$i);
                    $userAnswer->setResponse($parrafo);
                    $em->persist($userAnswer);
                    break;
                case 2:
                    break;
                case 3:
                    break;
                case 4:
                    $answerTF = $request->get('trueFalse'.$question->getIdQuestion());
                    $userAnswer->setResponse($answerTF);
                    $em->persist($userAnswer);
                    break;
                case 6:
                    break;
                case 7:
                    break;
                case 8:
                    break;
            }
            $i++;
            $idQuestion = $request->get('idQuestion'.$i);
        }
        $em->flush();
        return $this->redirectToRoute('test_index');
    }

}
