<?php

namespace EvaluationsBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EvaluationsBundle\Entity\AnswerElement;

use EvaluationsBundle\Entity\Question;
//use EvaluationsBundle\Form\QuestionType;

/**
 * Question controller.
 *
 */
class trueFalseQuestionController extends Controller
{
    public function tfqNewAction($id_type, Request $request){
        $question = new Question();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('EvaluationsBundle\Form\QuestionType', $question);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $statement = $form['statementQuestion']->getData();
          if(!is_null($statement) && strlen($statement)<=5000){
            $idType = $em->getRepository('EvaluationsBundle:TypeQuestion')->find($id_type);
            $idArea = $em->getRepository('EvaluationsBundle:Area')->find($form['area']->getData());
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

            //guardar respuesta

            $em->persist($question);
            $em->flush();
            $idq = $question->getId();

            $answer1 = $request->request->get('group1');//PARA RESPUESTA 1
            $answer = new AnswerElement(); 
            $answer -> setContent($answer1);
            $answer -> setIsCorrect("true");
            $answer -> setOrderVar(1);
            $answer -> setIdQuestion($question);

            $em->persist($answer);
            $em->flush();


          //  $answer= $request->request->get("group1");

           //$answer = $_POST['group1'];
          //  	$answer = "radioselected";

            return $this->redirectToRoute('trueFalseQuestion_show', array(
            	'id' => $question->getId(),
            	//'ans' => $answer,
            	));
          }
        }

        return $this->render('EvaluationsBundle:Question:trueFalseQuestion.html.twig', array(
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
      //  $answer1 = "aqui el radio button";
      // $answer = $_POST['group1'];
      // $answer1 = $ans;



        return $this->render('EvaluationsBundle:Question:showTrueFalseQuestion.html.twig', array(
            'question' => $question,
            'delete_form' => $deleteForm->createView(),
           // 'hola' => $answer1,
        ));
    }

    /**
     * Displays a form to edit an existing Question entity.
     *
     */
    public function editAction(Request $request, Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('EvaluationsBundle\Form\QuestionType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('openQquestion_edit', array('id' => $question->getId()));
        }

        return $this->render('EvaluationsBundle:Question:editOpenQuestion.html.twig', array(
            'question' => $question,
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
        $form = $this->createDeleteForm($question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
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
            ->setAction($this->generateUrl('question_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
