<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EvaluationsBundle\Entity\Question;
use EvaluationsBundle\Form\QuestionType;
use EvaluationsBundle\Entity\Area;

/**
 * Question controller.
 *
 */
class QuestionController extends Controller
{
    /**
     * Lists all Question entities.
     *
     */
    public function indexAction()
    {
        //select id_question statement_question, name_area from question INNER JOIN area ON (question.id_area = area.id_area)
        $em = $this->getDoctrine()->getManager();

        $questions = $em->getRepository('EvaluationsBundle:Question')->findAll();
        return $this->render('question/index.html.twig', array(
            'questions' => $questions,
        ));
    }

    /**
     * Creates a new Question entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $types = $em->getRepository('EvaluationsBundle:TypeQuestion')->findAll();

        return $this->render('question/new.html.twig', array(
            'types' => $types,
        ));
    }

    /*  fileQuestionNew
     *
     */
    public function fileQuestionNewAction(Request $request, $id_type)
    {
        $question = new Question();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('EvaluationsBundle\Form\FileQuestionType', $question);
        $form->handleRequest($request);
        $areas = $em->getRepository('EvaluationsBundle:Area')->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $statement = $form['statementQuestion']->getData();
          if(!is_null($statement) && strlen($statement)<=5000){
            $idType = $em->getRepository('EvaluationsBundle:TypeQuestion')->find($id_type);
            $idArea = $em->getRepository('EvaluationsBundle:Area')->findOneBy(array('nameArea' => $request->request->get('area')));
            if(is_null($idArea)){
                $idArea = new Area();
                $idArea->setNameArea($request->request->get('area'));
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
            $file=$form['file']->getData();
            if (!is_null($file)) {
                $file=$form['file']->getData();  
                $ext=$file->guessExtension();
                $file_name=time().".".$ext;
                $file->move("uploads", $file_name);
                $question->setpathFileQuestion($file_name);
            } 
            $question->setIdType($idType);
            $question->setIdArea($idArea);
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('question_show', array('id' => $question->getId()));
          }
        }
        return $this->render('question/fileQuestionNew.html.twig', array(
            'question' => $question,
            'areas' => $areas,
            'type' => $id_type,
            'form' => $form->createView(),
        ));
    }

     public function editFileAction(Request $request, Question $question)
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForm = $this->createDeleteForm($question);
        $areas = $em->getRepository('EvaluationsBundle:Area')->findAll();
        $editForm = $this->createForm('EvaluationsBundle\Form\FileQuestionType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Recogemos el fichero
           $file=$editForm['image']->getData();
            if (!is_null($file)) {
               $ext=$file->guessExtension();
               if($ext=="jpg" || $ext=="jpeg" || $ext=="png"){
                $pathImage = $editForm['pathImageQuestion']->getData();
                $pathImage = explode(".", $pathImage);
                $pathImage =  $pathImage[0];
                $file_name=$pathImage."_".time().".".$ext;
                $file->move("uploads/images", $file_name);
                $question->setPathImageQuestion($file_name);
               }else{
                $question->setPathImageQuestion(null);
               }
            } 
            $file=$editForm['file']->getData();
            if (!is_null($file)) {
                $file=$editForm['file']->getData();  
                $ext=$file->guessExtension();
                $file_name=time().".".$ext;
                $file->move("uploads", $file_name);
                $question->setpathFileQuestion($file_name);
            }
            $idArea=$em->getRepository('EvaluationsBundle:Area')->find($editForm['area']->getData());
            $em->persist($question);
            $em->flush();
            return $this->redirectToRoute('question_show', array('id' => $question->getId()));
            // return $this->redirectToRoute('questionfile_edit', array('id' => $question->getId()));
        }

        return $this->render('question/fileQuestionEdit.html.twig', array(
            'question' => $question,
            'areas' => $areas,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Question entity.
     *
     */
    public function showAction(Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);

        return $this->render('question/show.html.twig', array(
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
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('EvaluationsBundle\Form\QuestionType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('question_edit', array('id' => $question->getId()));
        }

        return $this->render('question/edit.html.twig', array(
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
