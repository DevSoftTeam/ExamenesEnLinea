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
                        $file_name=$pathFile.".".$ext;
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
                    $answersCQ = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
                    $resp=""; $cont = 1;
                    foreach($answersCQ as $ans){
                        $select = $request->get('word'.$i.$cont);
                        $resp = $resp.$ans->getIdAnswerElement().",".$select." ";
                        $cont = $cont + 1;
                    }
                    $userAnswer->setResponse($resp);
                    $em->persist($userAnswer);
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
        $reviewAuto = true;
        if($reviewAuto){
            $this->autoCalification($test);
        }
        
        return $this->render('EvaluationsBundle:TestForm:scoreTest.html.twig', array(
            'testTaken' => $testTaken,
        ));
    }

    public function autoCalification($test){
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $answersTest = $em->getRepository('EvaluationsBundle:UserAnswer')->findBy(array('idUser'=>$user ,'idTest'=>$test));
        $testTaken = $em->getRepository('EvaluationsBundle:TestTaken')->findOneBy(array('idUser'=>$user,'idTest'=>$test));
        $score = 0.0;

        foreach($answersTest as $answerQuestion){
            $question = $answerQuestion->getIdQuestion();
            $scoreQuestion = $em->getRepository('EvaluationsBundle:TestQuestion')->findOneBy(array('idTest'=>$test, 'idQuestion'=>$question))->getPercent();
            $response = trim($answerQuestion->getResponse());
            switch($question->getIdType()->getIdType()){
                case 2:
                    $responses = explode(" ",$response);
                    foreach ($responses as $resp) {
                        $responseAE = explode(",",$resp);
                        $answerE = $em->getRepository('EvaluationsBundle:AnswerElement')->find((int)$responseAE[0]);
                        if ($answerE->getOrderVar() == $responseAE[1]) {
                            $score = $score + round($scoreQuestion/count($responses),2);
                        }else{
                            if($responseAE[1] != "" ){
                                $score = $score - round($scoreQuestion/count($responses),2);;
                            }
                        }
                    }
                    break;
                case 4:
                    $answersElement = $em->getRepository('EvaluationsBundle:AnswerElement')->findOneBy(array('idQuestion'=>$question));
                    if($response == $answersElement->getContent()){
                        $score = $score + $scoreQuestion;
                    }else{
                        if($response != "" ){
                            $score = $score - $scoreQuestion;
                        }
                    }
                    break;
                case 5:
                    if (trim($response) != "" ) {
                        $answerE = $em->getRepository('EvaluationsBundle:AnswerElement')->find($response);
                        if($answerE->getIsCorrect()){
                            $score = $score + $scoreQuestion;
                        }else {
                            $score = $score - $scoreQuestion;
                        } 
                    }
                    break;
                case 6:
                    if (trim($response) != "" ) {
                         $responses = explode(" ",$response);
                        foreach ($responses as $resp) {
                            $answerE = $em->getRepository('EvaluationsBundle:AnswerElement')->find($resp);
                            if ($answerE->getIsCorrect()) {
                                $score = $score + round($scoreQuestion/count($responses),2);
                            }else{
                                $score = $score - round($scoreQuestion/count($responses),2);;
                            }
                        }   
                    }
                    break;
                case 7:
                    $responses = explode(" ",$response);
                    foreach ($responses as $resp) {
                        $responseAE = explode(",",$resp);
                        $answerE = $em->getRepository('EvaluationsBundle:AnswerElement')->find((int)$responseAE[0]);
                        if ($answerE->getOrderVar() == $responseAE[1]) {
                            $score = $score + round($scoreQuestion/count($responses),2);
                        }else{
                            if($responseAE[1] != "" ){
                                $score = $score - round($scoreQuestion/count($responses),2);;
                            }
                        }
                    }
                    break;
                case 8:
                    $responses = explode(" ",$response);
                    foreach ($responses as $resp) {
                        $responseAE = explode(",",$resp);
                        $answerE = $em->getRepository('EvaluationsBundle:AnswerElement')->find((int)$responseAE[0]);
                        if ($answerE->getContent() == $responseAE[1]) {
                            $score = $score + round($scoreQuestion/count($responses),2);
                        }else{
                            if($responseAE[1] != "" ){
                                $score = $score - round($scoreQuestion/count($responses),2);;
                            }
                        }
                    }
                    break;
                case 9:
                    $responses = explode(" ",$response);
                    foreach ($responses as $resp) {
                        $responseAE = explode(",",$resp);
                        $answerE = $em->getRepository('EvaluationsBundle:AnswerElement')->find((int)$responseAE[0]);
                        if ($answerE->getIsCorrect()) {
                            if ($responseAE[1]=="TRUE") {
                                $score = $score + round($scoreQuestion/count($responses),2);
                            }else {
                                if($responseAE[1] != "" ){
                                $score = $score - round($scoreQuestion/count($responses),2);
                                }
                            }

                        }else{
                            if($responseAE[1] == "FALSE" ){
                                $score = $score + round($scoreQuestion/count($responses),2);
                            }else{
                                if($responseAE[1] != "" ){
                                $score = $score - round($scoreQuestion/count($responses),2);
                                }
                            }
                        }
                    }
                    break;
            }
        }
        $testTaken->setUserScore($score);
        $em->persist($testTaken);
        $em->flush();
    }

}
