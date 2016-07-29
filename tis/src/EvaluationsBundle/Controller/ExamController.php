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
            if($question->getIdType()->getIdType()==7 && count($answers)>2){
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
            $idType = $question->getIdType()->getIdType();
            switch ($idType) {
                case 1:
                    $parrafo = $request->get('answer'.$i);
                    $userAnswer->setResponse($parrafo);
                    $em->persist($userAnswer);
                    break;
                case 2:
                    $answersOrQ = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
                    $resp="";
                    foreach($answersOrQ as $ans){
                        $select = $request->get('select'.$ans->getIdAnswerElement());
                        $resp = $resp." ".$ans->getIdAnswerElement().",".$select;
                    }
                    $userAnswer->setResponse($resp);
                    $em->persist($userAnswer);
                    break;
                case 3:
                    $file=$request->files->get('file'.$i);
                    if (!is_null($file)) {
                       $ext=$file->guessExtension();
                       //if($ext=="pdf"){
                        $pathFile = $request->get('pathFile'.$i);
                        $pathFile = explode(".", $pathFile);
                        $pathFile =  $pathFile[0];
                        $file_name=$pathFile."_".time().".".$ext;
                        $file->move("uploads/users", $file_name);
                        $userAnswer->setResponse($file_name);
                        $em->persist($userAnswer);
                       /*}else{
                        $question->setPathImageQuestion(null);
                       }*/
                     }
                    break;
                case 4:
                    $answerTF = $request->get('trueFalse'.$question->getIdQuestion());
                    $userAnswer->setResponse($answerTF);
                    $em->persist($userAnswer);
                    break;
                case 5:
                    $ansUni = $request->get('radio'.$i);
                    $userAnswer->setResponse($ansUni);
                    $em->persist($userAnswer);
                    break;
                case 6:
                    $answersMQ = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
                    $resp="";
                    foreach($answersMQ as $ans){
                        $select = $request->get('check'.$ans->getIdAnswerElement());
                        if($select == 1){
                            $resp = $resp.$ans->getIdAnswerElement()." ";
                        }
                    }
                    $userAnswer->setResponse($resp);
                    $em->persist($userAnswer);
                    break;
                case 7:
                    $answersMatQ = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
                    $resp="";
                    for($j=1; $j<=count($answersMatQ)-1; $j=$j+2){
                        $select = $request->get('match'.$answersMatQ[$j]->getIdAnswerElement());
                        $resp = $resp.$answersMatQ[$j]->getIdAnswerElement().",".$select." ";
                    }
                    $userAnswer->setResponse($resp);
                    $em->persist($userAnswer);
                    break;
                case 8:
                    break;
                case 9:
                    $answersBTF = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
                    $resp="";
                    foreach($answersBTF as $ans){
                        $select = $request->get('group'.$ans->getIdAnswerElement());
                        $resp = $resp.$ans->getIdAnswerElement().",".$select." ";
                    }
                    $userAnswer->setResponse($resp);
                    $em->persist($userAnswer);
                    break;
            }
            $i++;
            $idQuestion = $request->get('idQuestion'.$i);
        }
        $em->flush();
        return $this->redirectToRoute('test_index');
    }

}
