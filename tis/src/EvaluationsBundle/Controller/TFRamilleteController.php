<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EvaluationsBundle\Entity\AnswerElement;
use EvaluationsBundle\Entity\Question;
use EvaluationsBundle\Entity\Area;

/**
 * TFRamilleteController controller.
 *
 */
class TFRamilleteController extends Controller
{
    public function newTFRamilleteAction($id_type, Request $request)
    {
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
                    $contentAns = trim($request->request->get('answer'.$i));
                    while(strlen($contentAns)>0) {
                        if(strlen($contentAns)<=600){
//                            $isTrue = $request->request->get('group'.$i);
////                            $valor = $_POST['group'.$i];
//                            $valor = isset($_POST['group' . $i]);
//                            if($valor=='falso'){
//                                $isTrue = 'false';
//                            }

                            $answer = new AnswerElement();
                            $answer->setIdQuestion($question);
                            $answer->setContent($contentAns);
                            $valor = $request->request->get("group".$i);
//                            $valor = isset($_POST['group' . $i]);
                            if($valor=='falso'){
                            $answer->setIsCorrect(FALSE);
                            }else {
                            $answer->setIsCorrect(TRUE);
                            }
                            $answer->setOrderVar($i);
                            $em->persist($answer);
                        }
                        $i=$i+2;
                        $contentAns = trim($request->request->get('answer'.$i));
                    }

                    $em->flush();

                    return $this->redirectToRoute('tframillete_show', array('id' => $question->getId()));
                }
            }
        }

        return $this->render('EvaluationsBundle:Question:newTFRamillete.html.twig', array(
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
    {//
        $deleteForm = $this->createDeleteForm($question);
        $em = $this->getDoctrine()->getManager();
        $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion' =>$question));
        return $this->render('EvaluationsBundle:Question:showTFRamillete.html.twig', array(
            'answers' => $answers,
            'question' => $question,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Question entity.
     *
     */
    public function editTFRamilleteAction(Request $request, Question $question)
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
                $nameArea = trim($request->request->get('area'));
                if(strlen($nameArea)>0){

                    $idArea = $em->getRepository('EvaluationsBundle:Area')->findOneBy(array('nameArea' => $nameArea));
                    /// si no exisite el area lo crea
                    if(is_null($idArea)){
                        $idArea = new Area();
                        $idArea->setNameArea($nameArea);
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
                        if(strlen($contentAns)<=600){
                            $answer = new AnswerElement();
                            $answer->setIdQuestion($question);
                            $answer->setContent($contentAns);
                            $answer->setOrderVar($i);
                            $em->persist($answer);
                        }
                        $i=$i+2;
                        $contentAns = trim($request->request->get('answer'.$i));
                    }

                    $em->flush();

                    return $this->redirectToRoute('tframillete_show', array('id' => $question->getId()));
                }
            }
        }
        return $this->render('EvaluationsBundle:Question:editTFRamillete.html.twig', array(
            'areas' => $areas,
            'question' => $question,
            'answers' => $answers,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
//        $oldImage = $question->getPathImageQuestion();
//        $em = $this->getDoctrine()->getManager();
//        $areas = $em->getRepository('EvaluationsBundle:Area')->findAll();
//        $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
//        $deleteForm = $this->createDeleteForm($question);
//        $editForm = $this->createForm('EvaluationsBundle\Form\QuestionType', $question);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//
//            $statement = $editForm['statementQuestion']->getData();
//          if(!is_null($statement) && strlen($statement)<=5000){
//            $idArea = $em->getRepository('EvaluationsBundle:Area')->findOneBy(array('nameArea' => $request->request->get('area')));
//            if(is_null($idArea)){
//                $idArea = new Area();
//                $idArea->setNameArea($request->request->get('area'));
//                $em->persist($idArea);
//            }
//            $file=$editForm['image']->getData();
//            if (!is_null($file)) {
//               $ext=$file->guessExtension();
//               if($ext=="jpg" || $ext=="jpeg" || $ext=="png"){
//                $pathImage = $editForm['pathImageQuestion']->getData();
//                $pathImage = explode(".", $pathImage);
//                $pathImage =  $pathImage[0];
//                $file_name=$pathImage."_".time().".".$ext;
//                $file->move("uploads/images", $file_name);
//
//                if ($oldImage!=null) {
//                    $oldImage = "uploads/images/".$oldImage;
//                    unlink($oldImage);
//                }
//
//                $question->setPathImageQuestion($file_name);
//               }else{
//                $question->setPathImageQuestion(null);
//               }
//             }
//            $question->setIdArea($idArea);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($question);
//
//            $answers = $em->getRepository('EvaluationsBundle:AnswerElement')->findBy(array('idQuestion'=>$question));
//            foreach ($answers as $answer) {
//                $em->remove($answer);
//            }
//
//              $i = 1;
//              $contentAns = trim($request->request->get('answer'.$i));
//              while(strlen($contentAns)>0) {
//                  if(strlen($contentAns)<=600){
//                      $answer = new AnswerElement();
//                      $answer->setIdQuestion($question);
//                      $answer->setContent($contentAns);
//                      $answer->setIsCorrect(isset($_POST['group' . $i]));
//                      $em->persist($answer);
//                  }
//                  $i=$i+2;
//                  $contentAns = trim($request->request->get('answer'.$i));
//              }
//
//              $em->flush();
//
//            return $this->redirectToRoute('tframillete_show', array('id' => $question->getId()));
//          }
//        }
//        return $this->render('EvaluationsBundle:Question:editTFRamillete.html.twig', array(
//            'areas' => $areas,
//            'question' => $question,
//            'answers' => $answers,
//            'edit_form' => $editForm->createView(),
//            'delete_form' => $deleteForm->createView(),
//        ));
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
            ->setAction($this->generateUrl('tframillete_delete', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }
}
