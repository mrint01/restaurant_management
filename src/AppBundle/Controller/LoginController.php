<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;


class LoginController extends Controller
{


    /**
     * @Route("/login", name="login")
     */
    public function LoginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        return $this->render('default/login.html.twig', array(
            'error'         => $error,
        ));

    }

    /**
     * @Route("/logout" , name="logout")
     */
    public function LogoutAction()
    {
        return null;
    }

}
