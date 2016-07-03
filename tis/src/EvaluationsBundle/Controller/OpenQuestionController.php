<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EvaluationsBundle\Entity\Question;
//use EvaluationsBundle\Form\QuestionType;

/**
 * Question controller.
 *
 */
class OpenQuestionController extends Controller
{
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository('EvaluationsBundle:Area')->findAll();
        return $this->render('EvaluationsBundle:Question:newOpenQuestion.html.twig',array('areas'=>$areas));
    }
    public function saveAction(Request $request){
        $question = new Question();
        $em = $this->getDoctrine()->getManager();
        $idType = $em->getRepository('EvaluationsBundle:TypeQuestion')->find(1);
        $idArea = $em->getRepository('EvaluationsBundle:Area')->find($request->request->get('area'));
        $statement = $request->request->get('statementQuestion');
        $file = $request->files->get('image');
        //$pathImage = $request->request->get('pathImageQuestion');

        // Recogemos el fichero
        //$file=$form['image']->getData();
        // Sacamos la extensión del fichero
        $ext=$file->guessExtension();
        // Le ponemos un nombre al fichero
        $file_name=time().".".$ext;
        // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
        $file->move("uploads", $file_name);
        // Establecemos el nombre de fichero en el atributo de la entidad
        $question->setPathImageQuestion($file_name);
        $question->setIdType($idType);
        $question->setIdArea($idArea);
        $question->setStatementQuestion($statement);

        $em->persist($question);
        $em->flush();

        return $this->redirectToRoute('question_index');
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
