<?php

namespace EvaluationsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
class LoginController extends Controller
{
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has("id"))
        {
//            return $this->redirect($this->generateUrl('evaluations_usersystem'));
            return $this->render('EvaluationsBundle:Login:index.html.twig');
        }else{
            $this->get('session')->getFlashBag()->add(
                'mensaje',
                'Debe estar logeado para ver este contenido'
            );
            return$this->render('EvaluationsBundle:Login:index.html.twig');
        }

    }

    public function loginAction() {
        return $this->render('EvaluationsBundle:Login:index.html.twig');
    }

    public function validateAction(Request $request)
    {
            $login = $request->request->get("login");
            $pass = $request->request->get("password");
            $user = $this->getDoctrine()->getRepository('EvaluationsBundle:UserSystem')
                -> findOneBy(array("login"=>$login, "password"=>$pass));
            if(!is_null($user))
            {
//                die("hola");
                $session = $request->getSession();
                $session->set("id", $user->getid());
                $session->set("name", $user->getName());
                $idUser = $user->getId();
//                echo $session->get("name");exit;
              return $this->redirect($this->generateUrl('usersystem_show', array("id"=> $idUser)));
            }else
            {
//                echo $login."</br>".$pass; exit;
//                die("acceso denegado");
                $this->get('session')->getFlashBag()->add(
                    'mensaje',
                    'Datos de Usuario y/o contraseña no válidos, intente de nuevo');
            }
            return $this->redirect($this->generateUrl('login_homepage'));
    }

    public function logoutAction(Request $request)
    {
        $session=$request->getSession();
        $session->clear();
        $this->get('session')->getFlashBag()->add(
            'mensaje',
            'Se ha cerrado sesion exitosamente'
        );
        return $this->redirect($this->generateUrl('login_homepage'));
    }
}
