<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EvaluationsBundle\Entity\AnswerElement;
use EvaluationsBundle\Entity\Question;
use EvaluationsBundle\Form\Area;



class matchingQuestionController extends Controller
{
    public function mqNewAction($id_type, Request $request){
        $question = new Question();
        $em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository("EvaluationsBundle:Area")->findAll();//areas
        $form = $this->createForm('EvaluationsBundle\Form\QuestionType', $question);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $statement = $form['statementQuestion']->getData();
          if(!is_null($statement) && strlen($statement)<=5000){
            $idType = $em->getRepository('EvaluationsBundle:TypeQuestion')->find($id_type);
            $idArea = $em->getRepository('EvaluationsBundle:Area')->findOneBy(array('nameArea' => $request->request->get('area')));

            if(is_null($idArea)){
                $idArea = new Area();
                $idArea->setNameArea($request->request->get('area'));
                $em->persist($idArea);
                $em->flush();
            }

            $file=$form['image']->getData();
            if (!is_null($file)) {
               $ext=$file->guessExtension();
               if($ext=="jpg" || $ext=="jpeg" || $ext=="png"){
                $pathImage = $form['pathImageQuestion']->getData();
                $pathImage = explode(".", $pathImage);
                $pathImage =  $pathImage[0];
                $file_name=$pathImage."_".time().".".$ext;
                $file->move("uploads/images", $file_name);
                $question->setPathImageQuestion($file_name);
               }else{
                $question->setPathImageQuestion(null);
               }
             }  
            $question->setIdType($idType);
            $question->setIdArea($idArea);

            $em->persist($question);
            
            $answer1 = $request->request->get('answerA1');//PARA RESPUESTA 1
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answer1);
            $answer->setOrderVar("1");
            $answer->setIdType("7");
           // $answer->setIsCorrect();
            $em->persist($answer);
            $em->flush();

            $answer2 = $request->request->get('answerA2');//PARA RESPUESTA 2
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answer2);
            $answer->setOrderVar("2");
            $answer->setIdType("7");
           // $answer->setIsCorrect(isset($_POST['chec2']));
            $em->persist($answer);
            $em->flush();

            $answer3 = $request->request->get('answerA3');//PARA RESPUESTA 3
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answer3);
            $answer->setOrderVar("3");
            $answer->setIdType("7");
       //     $answer->setIsCorrect(isset($_POST['chec3']));
            $em->persist($answer);
            $em->flush();

            $answer4 = $request->request->get('answerA4');//PARA RESPUESTA 4
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answer4);
            $answer->setOrderVar("4");
            $answer->setIdType("7");
         //   $answer->setIsCorrect(isset($_POST['chec4']));
            $em->persist($answer);
            $em->flush();

            $answer5 = $request->request->get('answerA5');//PARA RESPUESTA 5
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answer5);
            $answer->setOrderVar("5");
            $answer->setIdType("7");
        //    $answer->setIsCorrect(isset($_POST['chec5']));
            $em->persist($answer);
            $em->flush();



            $answerB1 = $request->request->get('answerB1');//PARA RESPUESTA 1
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answerB1);
            $ord1 = $request->request->get('orderB1');
            $answer->setOrderVar("1");
            $answer->setIdType("7");
        //  $answer->setIsCorrect());
            $em->persist($answer);
            $em->flush();

            $answerB2 = $request->request->get('answerB2');//PARA RESPUESTA 2
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answerB2);
            $answer->setOrderVar("2");
            $answer->setIdType("7");
         //   $answer->setIsCorrect(isset($_POST['chec2']));
            $em->persist($answer);
            $em->flush();

            $answerB3 = $request->request->get('answerB3');//PARA RESPUESTA 3
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answerB3);
            $answer->setOrderVar("3");
            $answer->setIdType("7");
         //   $answer->setIsCorrect(isset($_POST['chec3']));
            $em->persist($answer);
            $em->flush();

            $answerB4 = $request->request->get('answerB4');//PARA RESPUESTA 4
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answerB4);
            $answer->setOrderVar("4");
            $answer->setIdType("7");
        //    $answer->setIsCorrect(isset($_POST['chec4']));
            $em->persist($answer);
            $em->flush();

            $answerB5 = $request->request->get('answerB5');//PARA RESPUESTA 5
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answerB5);
            $answer->setOrderVar("5");
            $answer->setIdType("7");
        //    $answer->setIsCorrect(isset($_POST['chec5']));
            $em->persist($answer);
            $em->flush();




            return $this->redirectToRoute('matchingQuestion_show', array('id' => $question->getId()));
          }
        }

        return $this->render('EvaluationsBundle:Question:newMatchingQuestion.html.twig', array(
            'areas' => $areas,
            'question' => $question,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Question entity.
     *
     */
    public function showAction(Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $em = $this->getDoctrine()->getManager();
        $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion' =>$question));

        return $this->render('EvaluationsBundle:Question:showMatchingQuestion.html.twig', array(
            'question' => $question,
            'answers' => $answers,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Question entity.
     *
     */
    public function editAction(Request $request, Question $question)
    {
       $oldImage = $question->getPathImageQuestion();
        $em = $this->getDoctrine()->getManager();
        $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
        $areas = $em->getRepository('EvaluationsBundle:Area')->findAll();
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('EvaluationsBundle\Form\QuestionType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $statement = $editForm['statementQuestion']->getData();
          if(!is_null($statement) && strlen($statement)<=5000){
            $idArea = $em->getRepository('EvaluationsBundle:Area')->findOneBy(array('nameArea' => $request->request->get('area')));
            /// si no exisite el area lo crea
            if(is_null($idArea)){
                $idArea = new Area();
                $idArea->setNameArea($request->request->get('area'));
                $em->persist($idArea);
                $em->flush();
            }
            $file=$editForm['image']->getData();
            if (!is_null($file)) {
               $ext=$file->guessExtension();
               if($ext=="jpg" || $ext=="jpeg" || $ext=="png"){
                $pathImage = $editForm['pathImageQuestion']->getData();
                $pathImage = explode(".", $pathImage);
                $pathImage =  $pathImage[0];
                $file_name=$pathImage."_".time().".".$ext;
                $file->move("uploads/images", $file_name);

                if ($oldImage!=null) {
                    $oldImage = "uploads/images/".$oldImage;
                    unlink($oldImage);
                } 

                $question->setPathImageQuestion($file_name);          
               }else{
                $question->setPathImageQuestion(null);
               }
             }  
            $question->setIdArea($idArea);

            $em = $this->getDoctrine()->getManager();
            $em->persist($question);

            $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
            foreach ($answers as $answer) {
                $em->remove($answer);
            }

$answer1 = $request->request->get('answerA1');//PARA RESPUESTA 1
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answer1);
            $answer->setOrderVar("1");
            $answer->setIdType("7");
           // $answer->setIsCorrect();
            $em->persist($answer);
            $em->flush();

            $answer2 = $request->request->get('answerA2');//PARA RESPUESTA 2
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answer2);
            $answer->setOrderVar("2");
            $answer->setIdType("7");
           // $answer->setIsCorrect(isset($_POST['chec2']));
            $em->persist($answer);
            $em->flush();

            $answer3 = $request->request->get('answerA3');//PARA RESPUESTA 3
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answer3);
            $answer->setOrderVar("3");
            $answer->setIdType("7");
       //     $answer->setIsCorrect(isset($_POST['chec3']));
            $em->persist($answer);
            $em->flush();

            $answer4 = $request->request->get('answerA4');//PARA RESPUESTA 4
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answer4);
            $answer->setOrderVar("4");
            $answer->setIdType("7");
         //   $answer->setIsCorrect(isset($_POST['chec4']));
            $em->persist($answer);
            $em->flush();

            $answer5 = $request->request->get('answerA5');//PARA RESPUESTA 5
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answer5);
            $answer->setOrderVar("5");
            $answer->setIdType("7");
        //    $answer->setIsCorrect(isset($_POST['chec5']));
            $em->persist($answer);
            $em->flush();



            $answerB1 = $request->request->get('answerB1');//PARA RESPUESTA 1
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answerB1);
            $ord1 = $request->request->get('orderB1');
            $answer->setOrderVar("1");
            $answer->setIdType("7");
        //  $answer->setIsCorrect());
            $em->persist($answer);
            $em->flush();

            $answerB2 = $request->request->get('answerB2');//PARA RESPUESTA 2
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answerB2);
            $answer->setOrderVar("2");
            $answer->setIdType("7");
         //   $answer->setIsCorrect(isset($_POST['chec2']));
            $em->persist($answer);
            $em->flush();

            $answerB3 = $request->request->get('answerB3');//PARA RESPUESTA 3
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answerB3);
            $answer->setOrderVar("3");
            $answer->setIdType("7");
         //   $answer->setIsCorrect(isset($_POST['chec3']));
            $em->persist($answer);
            $em->flush();

            $answerB4 = $request->request->get('answerB4');//PARA RESPUESTA 4
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answerB4);
            $answer->setOrderVar("4");
            $answer->setIdType("7");
        //    $answer->setIsCorrect(isset($_POST['chec4']));
            $em->persist($answer);
            $em->flush();

            $answerB5 = $request->request->get('answerB5');//PARA RESPUESTA 5
            $answer = new AnswerElement();
            $answer->setIdQuestion($question);
            $answer->setContent($answerB5);
            $answer->setOrderVar("5");
            $answer->setIdType("7");
        //    $answer->setIsCorrect(isset($_POST['chec5']));
            $em->persist($answer);
            $em->flush();



            return $this->redirectToRoute('matchingQuestion_show', array('id' => $question->getId()));
          }
        }

        return $this->render('EvaluationsBundle:Question:editMatchingQuestion.html.twig', array(
            'areas' => $areas,
            'question' => $question,
            'answers' => $answers,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Question entity.
     *
     */
    public function deleteAction(Request $request, Question $question)
{
        $oldImage = $question->getPathImageQuestion();
        $form = $this->createDeleteForm($question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($oldImage!=null) {
                    $oldImage = "uploads/images/".$oldImage;
                    unlink($oldImage);
                }

            $em = $this->getDoctrine()->getManager();
            $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
            foreach ($answers as $answer) {
                $em->remove($answer);
            }
            $em->remove($question);
            $em->flush();
        }

        return $this->redirectToRoute('question_index');
    }
    /**
     * Creates a form to delete a Question entity.
     *
     * @param Question $question The Question entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Question $question)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('matchingQuestion_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
