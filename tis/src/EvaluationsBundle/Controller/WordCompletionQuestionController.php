<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EvaluationsBundle\Entity\AnswerElement;
use EvaluationsBundle\Entity\Question;
use EvaluationsBundle\Entity\Area;

/**
 * OpenQuestion controller.
 *
 */
class WordCompletionQuestionController extends Controller
{
    public function wcqNewAction($id_type, Request $request){

        $question = new Question();
        $em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository('EvaluationsBundle:Area')->findAll();
        $form = $this->createForm('EvaluationsBundle\Form\QuestionType', $question);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $statement = $form['statementQuestion']->getData();
          if(!is_null($statement) && strlen($statement)<=5000){
            $idType = $em->getRepository('EvaluationsBundle:TypeQuestion')->find($id_type);
            $nameArea = trim($request->request->get('area'));
            if(strlen($nameArea)>0){

                $idArea = $em->getRepository('EvaluationsBundle:Area')->findOneBy(array('nameArea' => $nameArea));
                if(is_null($idArea)){
                    $idArea = new Area();
                    $idArea->setNameArea($nameArea);
                    $em->persist($idArea);
                    //$em->flush();
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
                $ques=$question->getStatementQuestion();


                 $claves = preg_split("/[[:space:]]/", $ques);
               
                $i = 1;
                $j=0;
                $size=count($claves);

                
                if($ques!="" ){
                   while(($size-1)>=0){
                    $pos = strpos($claves[$j],'[*');
                    $pos2= strpos($claves[$j],'*]');
                    if($pos === false or $pos2 ===false){
                        $size=$size-1;
                        $j=$j+1;
                    }
                        else{if($claves[$j] != ""){
                        $answer = new AnswerElement();
                        $answer->setIdQuestion($question);
                        $answer->setContent(substr($claves[$j], 2, -2));
                        $answer->setOrderVar($i);
                        $answer->setIsCorrect(True);
                        $em->persist($answer);
                        $size=$size-1;
                        $j=$j+1;}
                        }
              }
            }

                $em->flush();

                return $this->redirectToRoute('wordCompletionQuestion_show', array('id' => $question->getId()));
            }
          }
        }

        return $this->render('EvaluationsBundle:Question:newWordCompletionQuestion.html.twig', array(
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
        return $this->render('EvaluationsBundle:Question:showWordCompletionQuestion.html.twig', array(
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


                
               $ques=$question->getStatementQuestion();


                 $claves = preg_split("/[[:space:]]/", $ques);
               
                $i = 1;
                $j=0;
                $size=count($claves);

                
                if($ques!="" ){
                   while(($size-1)>=0){
                    $pos = strpos($claves[$j],'[*');
                    $pos2= strpos($claves[$j],'*]');
                    if($pos === false or $pos2 ===false){
                        $size=$size-1;
                        $j=$j+1;
                    }
                        else{
                        $answer = new AnswerElement();
                        $answer->setIdQuestion($question);
                        $answer->setContent(substr($claves[$j], 2, -2));
                        //$answer->setContent($claves[$j]);
                        $answer->setOrderVar($i);
                        $answer->setIsCorrect(True);
                        $em->persist($answer);
                        $size=$size-1;
                        $j=$j+1;
                        }
              }
            }

                $em->flush();

            return $this->redirectToRoute('wordCompletionQuestion_show', array('id' => $question->getId()));
          }
        }
        return $this->render('EvaluationsBundle:Question:editWordCompletionQuestion.html.twig', array(
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
            ->setAction($this->generateUrl('wordCompletionQuestion_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
