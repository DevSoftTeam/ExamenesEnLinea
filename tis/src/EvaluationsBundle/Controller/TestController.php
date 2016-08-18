<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EvaluationsBundle\Entity\Test;
use EvaluationsBundle\Entity\TestQuestion;
use Symfony\Component\HttpFoundation\Response;
use EvaluationsBundle\Entity\Question;
use EvaluationsBundle\Form\TestType;
use Symfony\Component\Validator\Constraints\Time;
/**
 * Test controller.
 *
 */
class TestController extends Controller
{
    /**
     * Lists all Test entities.
     *
     */
    public function indexAction()
    { 
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser();
        $tests = $em->getRepository('EvaluationsBundle:Test')->findBy(array('idUser'=>$idUser));
        $testsTaken = $em->getRepository('EvaluationsBundle:TestTaken')->findBy(array('idUser'=>$idUser));
        $testsT = array();
        foreach ($testsTaken as $testT) {
            array_push($testsT,$testT->getIdTest());
        }

        $testsAvailable = $em->getRepository('EvaluationsBundle:Test')->findAll();
        return $this->render('test/index.html.twig', array(
            'tests' => $tests,
            'testsT' => $testsT,
            'testsAvailable' => $testsAvailable,
        ));
    }

    public function searchAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser();

        $word = $request->get('bus'); //palabra que se va a buscar para coincidir
        $busq = $request->get('group1'); //por lo que se va a buscar (tittle, matter, institution)
        $word = strtolower($word);
        $repository = $em->getRepository('EvaluationsBundle:Test');
 //       $reptestsAvailable = $em->getRepository('EvaluationsBundle:Test');
        $testsTaken = $em->getRepository('EvaluationsBundle:TestTaken')->findBy(array('idUser'=>$idUser));
        $testsT = array();
        foreach ($testsTaken as $testT) {
            array_push($testsT,$testT->getIdTest());
        }


if ($busq == "tittle") { //buscar por titulo

$query = $repository->createQueryBuilder('p')
               ->where('LOWER(p.title) LIKE :word')
               ->setParameter('word', '%'.$word.'%')
               ->getQuery();
$testsResult = $query->getResult();

        $testsTaken = $em->getRepository('EvaluationsBundle:TestTaken')->findBy(array('idUser'=>$idUser));
        $testsT = array();
        foreach ($testsTaken as $testT) {
            array_push($testsT,$testT->getIdTest());
        }
$query2 = $repository->createQueryBuilder('p')
               ->where('LOWER(p.title) LIKE :word')
               ->andWhere('p.available=TRUE')
               ->setParameter('word', '%'.$word.'%')
               ->getQuery();


$testsResult = $query->getResult();
$testsAvailable = $query2->getResult();


} elseif ($busq == "matter") {

$query = $repository->createQueryBuilder('p')
               ->where('LOWER(p.matter) LIKE :word')
               ->setParameter('word', '%'.$word.'%')
               ->getQuery();
$query2 = $repository->createQueryBuilder('p')
               ->where('LOWER(p.matter) LIKE :word')
               ->andWhere('p.available=TRUE')
               ->setParameter('word', '%'.$word.'%')
               ->getQuery();



$testsResult = $query->getResult();
$testsAvailable = $query2->getResult();
} else {

$query = $repository->createQueryBuilder('p')
               ->where('LOWER(p.institution) LIKE :word')
               ->setParameter('word', '%'.$word.'%')
               ->getQuery();
$query2 = $repository->createQueryBuilder('p')
               ->where('LOWER(p.institution) LIKE :word')
               ->andWhere('p.available=TRUE')
               ->setParameter('word', '%'.$word.'%')
               ->getQuery();



$testsResult = $query->getResult();
$testsAvailable = $query2->getResult();
}

        return $this->render('test/searchResult.html.twig', array(
            'testsResult' => $testsResult, 'busq' => $word,'testsT' => $testsT,
            'testsAvailable' => $testsAvailable,
        ));
    }

    public function previewAction(Test $test)
    {
        $data = array();

        $em = $this->getDoctrine()->getManager();
        $result = $em->createQueryBuilder();
        $questions = $result->select(array('q'))
            ->from('EvaluationsBundle:Question', 'q')
            ->innerjoin('EvaluationsBundle:TestQuestion','t', 'WITH', 't.idQuestion = q.idQuestion and t.idTest = :idT')
            ->setParameter('idT' , $test->getIdTest())
            ->getQuery()
            ->getResult();
        $size = count($questions);
        $data = array();
        foreach ($questions as $value) {
            $resp = array();
            $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion' =>$value));
            $resp['question'] = $value;
            $resp['answerEl'] = $answers;
            $data[] = $resp;
        }
        //var_dump($resp['answerEl'][4]);
        //exit;
        $count = 0;
        $deleteForm = $this->createDeleteForm($test);
        return $this->render('test/preview.html.twig', array(
            'test' => $test,
            'data' => $data,
            'count' => $count,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    public function asosiationAction(Test $test){        
        $em = $this->getDoctrine()->getManager();
        $result = $em->createQueryBuilder(); 

        $questions = $result->select(array('q'))
            ->from('EvaluationsBundle:Question', 'q')
            ->leftjoin('EvaluationsBundle:TestQuestion','t', 'WITH', 't.idQuestion = q.idQuestion and t.idTest = :idT')
            ->where('t.idTest IS NULL')
            ->setParameter('idT' , $test->getIdTest())
            ->getQuery()
            ->getResult();

        $result = $em->createQueryBuilder();
        $score_asign = $result->select('sum(tq.percent) as score')
            ->from('EvaluationsBundle:TestQuestion', 'tq')
            ->where('tq.idTest = :idT')
            ->setParameter('idT' , $test->getIdTest())
            ->getQuery()
            ->getResult();
            $score_asign = $score_asign[0]['score'];
            if ($score_asign == null) {
                $score_asign = 0;
            }
        //var_dump($score_asign[0]['score']);exit;
        //$questions=$em->getRepository('EvaluationsBundle:Question')->findAll();
        return $this->render('test/asign.html.twig', array(
            'test' => $test,
            'score_asign' => $score_asign,
            'questions' => $questions,
        ));

    }

    public function asignscoreAction($idTest, $idUser){
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('EvaluationsBundle:Test')->find($idTest);
        $result = $em->createQueryBuilder();

        $questions = $em->getRepository('EvaluationsBundle:UserAnswer')->findBy(array('idTest'=>$idTest,'idUser'=>$idUser));
        
        $query = $em->createQuery( "SELECT answer
                                    FROM EvaluationsBundle:UserAnswer answer
                                    JOIN EvaluationsBundle:TestQuestion question
                                    WITH question.idQuestion = answer.idQuestion
                                    WHERE answer.idTest = ?1")
                                    ->setParameter('1',$idTest);
        $answersDetails = $query -> getResult();
        // var_dump($query);exit;

        return $this->render('test/asignscore.html.twig', array(
                'test' => $test,
                'questions' => $questions
            ));
    }

    public function score_asignedAction($testid,$questionid,$score){
        $msg = "";
        $em = $this->getDoctrine()->getManager();
        $UserAnswer=$em->getRepository('EvaluationsBundle:UserAnswer')->findOneBy(array('idTest'=>$testid,'idQuestion'=>$questionid));
        $TestQuestion=$em->getRepository('EvaluationsBundle:TestQuestion')->findOneBy(array('idTest'=>$testid,'idQuestion'=>$questionid));
        if ($TestQuestion->percent >= $score) {
            $UserAnswer->setScoreQuestion($score);
            $em->persist($UserAnswer);
            $em->flush();
            $msg = "agregado correctamente";
        }
        else{
            $msg = "El puntaje debe ser menor a ".$TestQuestion->percent;
        }
        
        $idUser = $UserAnswer->idUser->idUser;
        return $this->redirectToRoute('test_asign_score',array('idTest' => $testid,'idUser'=>$idUser,'msg'=>$msg));
    }

    public function asignAction($idT,$idQ, $percent, $ispenalized){
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('EvaluationsBundle:Test')->find($idT);
        $question = $em->getRepository('EvaluationsBundle:Question')->find($idQ);
        
        $testQuestion = new TestQuestion();
        $testQuestion->setIdQuestion($question);
        $testQuestion->setIdTest($test);
        $testQuestion->setPercent($percent);
        $testQuestion->setIsPenalized($ispenalized);
        $em->persist($testQuestion);
        $test->setAvailable(true);
        $em->persist($test);
        $em->flush();
        return $this->redirectToRoute('test_asosiation',array('id' => $test->getId(),'msg'=>'mensaje'));
    }

    public function asign_editAction($idT,$idQ, $percent, $ispenalized){
        $em = $this->getDoctrine()->getManager();
        
        $testQuestion = $em->getRepository('EvaluationsBundle:TestQuestion')->find(array('idTest'=>$idT,'idQuestion'=>$idQ));
         
        $testQuestion->setPercent($percent);
        $testQuestion->setIsPenalized($ispenalized);
        $em->persist($testQuestion);
        $em->flush();
        return $this->redirectToRoute('test_show',array('id' => $idT,'msg'=>'La nota de la pregunta fue editada'));
    }


     public function dropAction($idT,$idQ){
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('EvaluationsBundle:Test')->find($idT);
        $question = $em->getRepository('EvaluationsBundle:Question')->find($idQ);
        
        $testQuestion = $em->getRepository('EvaluationsBundle:TestQuestion')->findOneBy(array('idQuestion'=>$question,'idTest'=>$test));


        $em->remove($testQuestion); //delete from test_question Where test_Question.id_Test = idT and test_question.id_Question= idQ
        $em->flush();
        return $this->redirectToRoute('test_data',array('id' => $test->getId(),'msg'=>'Esta pregunta se elimino del examen'));
    }

    public function newAction(Request $request)
    {
        $test = new Test();
        $form = $this->createForm('EvaluationsBundle\Form\TestType', $test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $sDate = $form['startDate']->getData();
            $sTime = $form['startTime']->getData();

            $eDate = $form['endDate']->getData();
            $eTime = $form['endTime']->getData();

            $sEDate = $form['startDateEnrollment']->getData();
            $sETime = $form['startTimeEnrollment']->getData();

            $eEDate = $form['endDateEnrollment']->getData();
            $eETime = $form['endTimeEnrollment']->getData();

            if(($sDate > $eEDate) || ($sDate == $eEDate and $sTime >= $eETime))
            {
                if($sDate < $eDate || ($sDate == $eDate and $sTime < $eTime) and
                    ($sEDate == $eEDate and $sETime < $eETime )|| $sEDate < $eEDate)
                {
                    $userSession = $this->getUser();
                    $test->setIdUser($userSession);
                    $test->setAvailable(false);
                    $em->persist($test);
                    $em->flush();
                    return $this->redirectToRoute('test_show', array('id' => $test->getId()));
                }
            }

        }

        return $this->render('test/new.html.twig', array(
            'test' => $test,
            'mensaje'=>"mensaje uno",
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Test entity.
     *
     */
    public function showAction(Test $test)
    {
        $em = $this->getDoctrine()->getManager();
        $result = $em->createQueryBuilder();
        $questions = $result->select(array('t'))
            ->from('EvaluationsBundle:Question', 'q')
            ->innerjoin('EvaluationsBundle:TestQuestion','t', 'WITH', 't.idQuestion = q.idQuestion and t.idTest = :idT')
            ->setParameter('idT' , $test->getIdTest())
            ->getQuery()
            ->getResult();

        $result = $em->createQueryBuilder();
        $score_asign = $result->select('sum(tq.percent) as score')
            ->from('EvaluationsBundle:TestQuestion', 'tq')
            ->where('tq.idTest = :idT')
            ->setParameter('idT' , $test->getIdTest())
            ->getQuery()
            ->getResult();
            $score_asign = $score_asign[0]['score'];
            if ($score_asign == null) {
                $score_asign = 0;
            }
        $deleteForm = $this->createDeleteForm($test);
        return $this->render('test/show.html.twig', array(
            'test' => $test,
            'questions' => $questions,
            'score_asign' => $score_asign,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Test entity.
     *
     */
    public function editAction(Request $request, Test $test)
    {
        $deleteForm = $this->createDeleteForm($test);
        $editForm = $this->createForm('EvaluationsBundle\Form\TestType', $test);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $sDate = $editForm['startDate']->getData();
            $sTime = $editForm['startTime']->getData();
            $eDate = $editForm['endDate']->getData();
            $eTime = $editForm['endTime']->getData();
            $sEDate = $editForm['startDateEnrollment']->getData();
            $sETime = $editForm['startTimeEnrollment']->getData();
            $eEDate = $editForm['endDateEnrollment']->getData();
            $eETime = $editForm['endTimeEnrollment']->getData();
            $now = new \DateTime();
            if(($sDate > $eEDate) || ($sDate == $eEDate and $sTime >= $eETime))
            {
                if($sDate < $eDate || ($sDate == $eDate and $sTime < $eTime) and
                    ($sEDate == $eEDate and $sETime < $eETime )|| $sEDate < $eEDate)
                {
                $em = $this->getDoctrine()->getManager();
                    $em->persist($test);
                    $em->flush();
                    return $this->redirectToRoute('test_show', array('id' => $test->getId()));
                }
            }
        }
        return $this->render('test/edit.html.twig', array(
            'test' => $test,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Test entity.
     *
     */
    public function deleteAction(Request $request, Test $test)
    {
        $form = $this->createDeleteForm($test);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($test);
            $em->flush();
        }

        return $this->redirectToRoute('test_index');
    }

//    public function convertToPdfAction($idTest){ //$html) {
//
//////        $html = 'hello world';
////        $html = include('http://www.google.com');
//////       echo $html;exit;
////        $options = new Options();
////        $options->set('defaultFont', 'Courier');
////        $dompdf = new Dompdf($options);
////        $dompdf->loadHtml($html);//$dompdf = new Dompdf();
////        $dompdf->setPaper('A4', 'landscape'); // (Optional) Setup the paper size and orientation
////        $dompdf->render();// Render the HTML as PDF
////        $dompdf->stream();// Output the generated PDF to Browser
//
////        $container->get('knp_snappy.image')->generate('http://www.google.fr', '/path/to/the/image.jpg');
//
//    }

//    /**
//     * @Route("/archivopdf", name="archivopdf")
//     * @Method("GET")
//     * @Template("test/show.html.twig")
//     */
//    public function convertToPdfAction($test)
//    {
//        $pageUrl = $this->generateUrl('login_homepage', array(), true); // use absolute path!
//
//        return new Response(
//            $this->get('knp_snappy.pdf')->getOutput($pageUrl),
//            200,
//            array(
//                'Content-Type'          => 'tis/',
//                'Content-Disposition'   => 'attachment; filename="file.pdf"'
//            )
//        );
//        $em = $this->getDoctrine()->getManager();
////        $entities = $em->getRepository('EvaluationsBundle:Test')->find($idTest);
//
//        $html =$this->renderView('test/show.html.twig',
//        array(
//        'test' => $test,
//        ));
//
//        $response = new Response (
//        $this->get('knp_snappy.pdf')->getOutputFromHtml($html,
//        array('lowquality' => false,
//            'print-media-type' => true,
//            'encoding' => 'utf-8',
//            'page-size' => 'Letter',
//            'outline-depth' => 8,
//            'orientation' => 'Portrait',
//            'title'=> 'Personal con Certificado',
//            'user-style-sheet'=> 'css/bootstrap.css',
//            'header-right'=>'Pag. [page] de [toPage]',
//            'header-font-size'=>7,
//            )
//        ),
//        200,
//        array(
//            'Content-Type'=>'/home/usuario/public_html/Proyecto/web/pdf',
//            'Content-Disposition'=> 'attachment;
//            filename="nombredearchivo.pdf"',
//            )
//        );
//        return $response;
//    }

//    public function pdf_create($html, $filename, $paper, $orientation, $stream=TRUE) {
//        $dompdf = new Dompdf();
//        $dompdf->set_paper($paper, $orientation);
//        $dompdf->load_html($html);
//        $dompdf->render();
//        $dompdf->stream($filename.".pdf");
//    }


    /**
     * Creates a form to delete a Test entity.
     *
     * @param Test $test The Test entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Test $test)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('test_delete', array('id' => $test->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /*codigo de jhannet para recuperar informacion del examen dado*/
    public function asignscore2Action($idTest, $idUser)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $test = $em->getRepository('EvaluationsBundle:Test')->find($idTest);
        $testTaken = $em->getRepository('EvaluationsBundle:TestTaken')->findOneBy(array('idUser'=>$user,'idTest'=>$test));
        $userAnswers = $em->getRepository('EvaluationsBundle:UserAnswer')->findBy(array('idUser'=>$user,'idTest'=>$test),array('idUserAnswer' => 'ASC'));
        
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
                //shuffle($columB);
                $answers = array_merge($columA,$columB);
            }
            $resp['question'] = $question;
            $resp['answers'] = $answers;
            $data[] = $resp;
        }
        $testsQuestion = $em->getRepository('EvaluationsBundle:TestQuestion')->findBy(array('idTest'=>$test));
        $questionsPenalized = array();
        foreach ($testsQuestion as $testQuestion) {
            if ($testQuestion->getIsPenalized()) {
                array_push($questionsPenalized,$testQuestion->getIdQuestion());
            }
        }

        return $this->render('test/asignscore2.html.twig', array(
            'testTaken' => $testTaken,
            'userAnswers' => $userAnswers,
            'testsQuestion' => $testsQuestion,
            'data' => $data,
            'test_id' => $idTest,
            'user_id' => $idUser,
            'questionsPenalized' => $questionsPenalized,
        ));
    }

}
