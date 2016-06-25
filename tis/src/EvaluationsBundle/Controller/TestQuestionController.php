<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EvaluationsBundle\Entity\TestQuestion;
use EvaluationsBundle\Form\TestQuestionType;

/**
 * TestQuestion controller.
 *
 */
class TestQuestionController extends Controller
{
    /**
     * Lists all TestQuestion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $testQuestions = $em->getRepository('EvaluationsBundle:TestQuestion')->findAll();

        return $this->render('testquestion/index.html.twig', array(
            'testQuestions' => $testQuestions,
        ));
    }

    /**
     * Creates a new TestQuestion entity.
     *
     */
    public function newAction(Request $request)
    {
        $testQuestion = new TestQuestion();
        $form = $this->createForm('EvaluationsBundle\Form\TestQuestionType', $testQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($testQuestion);
            $em->flush();

            return $this->redirectToRoute('testquestion_show', array('id' => $testQuestion->getId()));
        }

        return $this->render('testquestion/new.html.twig', array(
            'testQuestion' => $testQuestion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TestQuestion entity.
     *
     */
    public function showAction(TestQuestion $testQuestion)
    {
        $deleteForm = $this->createDeleteForm($testQuestion);

        return $this->render('testquestion/show.html.twig', array(
            'testQuestion' => $testQuestion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TestQuestion entity.
     *
     */
    public function editAction(Request $request, TestQuestion $testQuestion)
    {
        $deleteForm = $this->createDeleteForm($testQuestion);
        $editForm = $this->createForm('EvaluationsBundle\Form\TestQuestionType', $testQuestion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($testQuestion);
            $em->flush();

            return $this->redirectToRoute('testquestion_edit', array('id' => $testQuestion->getId()));
        }

        return $this->render('testquestion/edit.html.twig', array(
            'testQuestion' => $testQuestion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TestQuestion entity.
     *
     */
    public function deleteAction(Request $request, TestQuestion $testQuestion)
    {
        $form = $this->createDeleteForm($testQuestion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($testQuestion);
            $em->flush();
        }

        return $this->redirectToRoute('testquestion_index');
    }

    /**
     * Creates a form to delete a TestQuestion entity.
     *
     * @param TestQuestion $testQuestion The TestQuestion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TestQuestion $testQuestion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('testquestion_delete', array('id' => $testQuestion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
