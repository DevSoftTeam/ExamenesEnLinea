<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EvaluationsBundle\Entity\AnswerElement;
use EvaluationsBundle\Entity\Question;
use EvaluationsBundle\Entity\Area;
//use EvaluationsBundle\Form\QuestionType;

/**
 * OpenQuestion controller.
 *
 */
class uniqueAnswerQuestionController extends Controller
{
    public function uaqNewAction($id_type, Request $request){
        $question = new Question();
        $em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository("EvaluationsBundle:Area")->findAll();//areas
        $form = $this->createForm('EvaluationsBundle\Form\QuestionType', $question);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $statement = $form['statementQuestion']->getData();
          if(!is_null($statement) && strlen($statement)<=5000){
            $idType = $em->getRepository('EvaluationsBundle:TypeQuestion')->find($id_type);

                $idArea = $em->getRepository('EvaluationsBundle:Area')->findOneBy(array('nameArea'=>$request->request->get("area")));
               if(is_null($idArea)){
                    $idArea = new Area();
                    $idArea->setNameArea($request->request->get('area'));
                    $em->persist($idArea);
                   // $em->flush();
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

                $var = $request->request->get("chec1");
                $answer1 = $request->request->get('answer1');//PARA RESPUESTA 1
                $answer = new AnswerElement();
                if($answer1!="" && strlen(trim($answer1))>0){
                $answer->setIdQuestion($question);
                $answer->setContent($answer1);
                $answer->setOrderVar("1");
                if($var == 1){
                    $answer->setIsCorrect(True);
                }
                else{$answer->setIsCorrect(False);}
                $em->persist($answer);
                $em->flush();}

                
                //$var = $request->request->get("chec2");
                $answer2 = $request->request->get('answer2');//PARA RESPUESTA 2
                $answer = new AnswerElement();
                if($answer2!="" && strlen(trim($answer2))>0){
                $answer->setIdQuestion($question);
                $answer->setContent($answer2);
                $answer->setOrderVar("2");
                if($var == 1){
                    $answer->setIsCorrect(True);
                }
                else{$answer->setIsCorrect(False);}
                $em->persist($answer);
                $em->flush();}

                $answer3 = $request->request->get('answer3');//PARA RESPUESTA 3
                $answer = new AnswerElement();
                if($answer2!="" && strlen(trim($answer3))>0){
                $answer->setIdQuestion($question);
                $answer->setContent($answer3);
                $answer->setOrderVar("3");
                if($var == 1){
                    $answer->setIsCorrect(True);
                }
                else{$answer->setIsCorrect(False);}
                $em->persist($answer);
                $em->flush();}

                $answer4 = $request->request->get('answer4');//PARA RESPUESTA 4
                $answer = new AnswerElement();
                if($answer4!="" && strlen(trim($answer4))>0){
                $answer->setIdQuestion($question);
                $answer->setContent($answer4);
                $answer->setOrderVar("4");
                if($var == 1){
                    $answer->setIsCorrect(True);
                }
                else{$answer->setIsCorrect(False);}
                $em->persist($answer);
                $em->flush();}

                $answer5 = $request->request->get('answer5');//PARA RESPUESTA 5
                $answer = new AnswerElement();
                if($answer5!="" && strlen(trim($answer5))>0){
                $answer->setIdQuestion($question);
                $answer->setContent($answer5);
                $answer->setOrderVar("5");
                if($var == 1){
                    $answer->setIsCorrect(True);
                }
                else{$answer->setIsCorrect(False);}
                $em->persist($answer);
                $em->flush();}


                 return $this->redirectToRoute('uniqueAnswerQuestion_show', array('id' => $question->getId()));
              }
        }

        return $this->render('EvaluationsBundle:Question:uniqueAnswerQuestion.html.twig', array(
            "areas" => $areas,
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
        return $this->render('EvaluationsBundle:Question:showUniqueAnswerQuestion.html.twig', array(
            'answers' => $answers,
            'question' => $question,
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
        $em = $this->getDoctrine()->getManager(); /// para enviar las areas
        $areas = $em->getRepository('EvaluationsBundle:Area')->findAll();
        $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
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
                //$em->flush();
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

            for ($i=1; $i <= 5; $i++) {
                $contentAns = $request->request->get('answer'.$i);
                $chec = $request->request->get('chec1');
                if(strlen(trim($contentAns))>0){
                    $answer = new AnswerElement();
                    $answer->setIdQuestion($question);
                    $answer->setContent($contentAns);
                    $answer->setIsCorrect($chec);
                    $em->persist($answer);
                }
            }
            $em->flush();

            return $this->redirectToRoute('uniqueAnswerQuestion_show', array('id' => $question->getId()));
          }
        }
        return $this->render('EvaluationsBundle:Question:editUniqueAnswerQuestion.html.twig', array(
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
            ->setAction($this->generateUrl('uniqueAnswerQuestion_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
