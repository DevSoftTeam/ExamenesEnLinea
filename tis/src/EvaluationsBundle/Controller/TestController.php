<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EvaluationsBundle\Entity\Test;
use EvaluationsBundle\Entity\TestQuestion;
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
        return $this->render('test/index.html.twig', array(
            'tests' => $tests,
        ));
    }

    public function searchAction(Request $request)
    { 
        $em = $this->getDoctrine()->getManager();
        $idUser = $this->getUser();

        


        $testsResult = $em->getRepository('EvaluationsBundle:Test')->findBy(array('idUser'=>$idUser));



        return $this->render('test/searchResult.html.twig', array(
            'testsResult' => $testsResult,
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

        $deleteForm = $this->createDeleteForm($test);
        return $this->render('test/preview.html.twig', array(
            'test' => $test,
            'data' => $data,
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
        //var_dump($score_asign[0]['score']);exit;
        //$questions=$em->getRepository('EvaluationsBundle:Question')->findAll();
        return $this->render('test/asign.html.twig', array(
            'test' => $test,
            'score_asign' => $score_asign[0]['score'],
            'questions' => $questions,
        ));

    }

    /*public function asosiationAction(Test $test){
        $em = $this->getDoctrine()->getManager();
        //"select q from Question q LEFT JOIN test_question ON (q.id_question = test_question.id_question) where id_test is null"

        $questions=$em->getRepository('EvaluationsBundle:Question')->findAll();
        return $this->render('test/asign.html.twig', array(
            'test' => $test,
            'questions' => $questions,
        ));

    }*/

    public function asignAction($idT,$idQ, $percent){
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('EvaluationsBundle:Test')->find($idT);
        $question = $em->getRepository('EvaluationsBundle:Question')->find($idQ);
        
        $testQuestion = new TestQuestion();
        $testQuestion->setIdQuestion($question);
        $testQuestion->setIdTest($test);
        $testQuestion->setPercent($percent);
        $em->persist($testQuestion);
        $em->flush();
        return $this->redirectToRoute('test_asosiation',array('id' => $test->getId(),'msg'=>'mensaje'));
    }

    //private function validateDateTimes(Date $startDate, Time $startTime, Date $entDate, Time $endTime, Form $form)
    //{

   

     public function dropAction($idT,$idQ){
        $em = $this->getDoctrine()->getManager();
        $test = $em->getRepository('EvaluationsBundle:Test')->find($idT);
        $question = $em->getRepository('EvaluationsBundle:Question')->find($idQ);
        
        $testQuestion = $em->getRepository('EvaluationsBundle:TestQuestion')->findOneBy(array('idQuestion'=>$question,'idTest'=>$test));


        $em->remove($testQuestion); //delete from test_question Where test_Question.id_Test = idT and test_question.id_Question= idQ
        $em->flush();
        return $this->redirectToRoute('test_data',array('id' => $test->getId(),'msg'=>'mensaje'));
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
                    $em->persist($test);
                    $em->flush();
                    return $this->redirectToRoute('test_show', array('id' => $test->getId()));
                }
            }
            return $this->render('test/errorFormTest.html.twig', array(
                'test' => $test,
                'form' => $form->createView(),
            ));
        }

        return $this->render('test/new.html.twig', array(
            'test' => $test,
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
        $questions = $result->select(array('q'))
            ->from('EvaluationsBundle:Question', 'q')
            ->innerjoin('EvaluationsBundle:TestQuestion','t', 'WITH', 't.idQuestion = q.idQuestion and t.idTest = :idT')
            ->setParameter('idT' , $test->getIdTest())
            ->getQuery()
            ->getResult();

        $deleteForm = $this->createDeleteForm($test);
        return $this->render('test/show.html.twig', array(
            'test' => $test,
            'questions' => $questions,
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
            return $this->render('test/errorFormTest.html.twig', array(
                'test' => $test,
                'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            ));
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

}
