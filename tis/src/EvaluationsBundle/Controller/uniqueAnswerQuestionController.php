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
        $areas = $em->getRepository('EvaluationsBundle:Area')->findAll();
        $form = $this->createForm('EvaluationsBundle\Form\QuestionType', $question);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $statement = $form['statementQuestion']->getData();
          if(!is_null($statement) && strlen($statement)<=5000){
            $idType = $em->getRepository('EvaluationsBundle:TypeQuestion')->find($id_type);
            $nameArea = trim($request->request->get('area'));//para validar area
            if(strlen($nameArea)>0){
                $idArea = $em->getRepository('EvaluationsBundle:Area')->findOneBy(array('nameArea' => $nameArea));
                if(is_null($idArea)){
                    $idArea = new Area();
                    $idArea->setNameArea($nameArea);
                    $em->persist($idArea);
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
                
                $userSession = $this->getUser();
                $question->setIdUser($userSession);
                $em->persist($question);

                $i = 1;
                $cont = 0;

                $contentAns = trim($request->request->get('answer'.$i));
                while(strlen($contentAns)>0) {
                    $var="var";

                    
                    $var = $request->request->get("chec1");
                    if(strlen($contentAns)<=600){
                        
                        $answer = new AnswerElement();
                        $answer->setIdQuestion($question);
                        $answer->setContent($contentAns);
                        $answer->setOrderVar($i);
                        if(True){
                            $answer->setIsCorrect(Null);
                            if($var == $i){
                                $answer->setIsCorrect(True);
                            }
                            else{if(is_numeric($var)){
                                $answer->setIsCorrect(False);}}
                        }
                        $em->persist($answer);}
                        $i=$i+1;
                    $contentAns = trim($request->request->get('answer'.$i));
                }


                $em->flush();

                return $this->redirectToRoute('uniqueAnswerQuestion_show', array('id' => $question->getId()));
                }
           }
        }

        return $this->render('EvaluationsBundle:Question:uniqueAnswerQuestion.html.twig', array(
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

               $i = 1;
                
                $contentAns = trim($request->request->get('answer'.$i));
                while(strlen($contentAns)>0) {
                    $var="var";
                    $var = $request->request->get("chec1");
                    if(strlen($contentAns)<=600){
                        $answer = new AnswerElement();
                        $answer->setIdQuestion($question);
                        $answer->setContent($contentAns);
                        $answer->setOrderVar($i);
                        if(True){
                            $answer->setIsCorrect(Null);
                            if($var == $i){
                                $answer->setIsCorrect(True);
                            }
                            else{if(is_numeric($var)){
                                $answer->setIsCorrect(False);}}
                        }
                        $em->persist($answer);
                    }
                    $i=$i+1;
                    $contentAns = trim($request->request->get('answer'.$i));
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
