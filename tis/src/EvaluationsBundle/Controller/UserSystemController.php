<?php

namespace EvaluationsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EvaluationsBundle\Entity\UserSystem;
use EvaluationsBundle\Form\UserSystemType;

/**
 * UserSystem controller.
 *
 */
class UserSystemController extends Controller
{
    /**
     * Lists all UserSystem entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userSystems = $em->getRepository('EvaluationsBundle:UserSystem')->findAll();

        return $this->render('usersystem/index.html.twig', array(
            'userSystems' => $userSystems,
        ));
    }

    public function indexAmction(Request $request)
    {
        $session = $request->getSession();
        if($session->has("id"))
        {
            return $this->render('EvaluationsBundle:Login:index.html.twig');
        }else{
            $this->get('session')->getFlashBag()->add(
                'mensaje',
                'Debe estar logeado para ver este contenido'
            );
            return$this->render('EvaluationsBundle:Login:index.html.twig');
        }

    }
    
    /**
     * Creates a new UserSystem entity.
     *
     */
    public function newAction(Request $request)
    {
        $userSystem = new UserSystem();
        $form = $this->createForm('EvaluationsBundle\Form\UserSystemType', $userSystem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userSystem);
            $em->flush();

            return $this->redirectToRoute('usersystem_show', array('id' => $userSystem->getId()));
        }

        return $this->render('usersystem/new.html.twig', array(
            'userSystem' => $userSystem,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a UserSystem entity.
     *
     */
    public function showAction(UserSystem $userSystem)
    {
        $deleteForm = $this->createDeleteForm($userSystem);

        return $this->render('usersystem/show.html.twig', array(
            'userSystem' => $userSystem,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing UserSystem entity.
     *
     */
    public function editAction(Request $request, UserSystem $userSystem)
    {
        $deleteForm = $this->createDeleteForm($userSystem);
        $editForm = $this->createForm('EvaluationsBundle\Form\UserSystemType', $userSystem);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userSystem);
            $em->flush();

//            return $this->redirectToRoute('test_show', array('id' => $test->getId()));
            return $this->redirectToRoute('usersystem_show', array('id' => $userSystem->getId()));
        }

        return $this->render('usersystem/edit.html.twig', array(
            'userSystem' => $userSystem,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a UserSystem entity.
     *
     */
    public function deleteAction(Request $request, UserSystem $userSystem)
    {
        $form = $this->createDeleteForm($userSystem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($userSystem);
            $em->flush();
        }

        return $this->redirectToRoute('usersystem_index');
    }

    /**
     * Creates a form to delete a UserSystem entity.
     *
     * @param UserSystem $userSystem The UserSystem entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserSystem $userSystem)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usersystem_delete', array('id' => $userSystem->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
