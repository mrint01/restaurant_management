<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Usr;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ResetPassController extends Controller
{
    /**
     * @Route("/reset_password" , name="forgotten_password")
     */
    public function IndexAction(Request $request,
                                UserPasswordEncoderInterface $encoder,
                                \Swift_Mailer $mailer,
                                TokenGeneratorInterface $tokenGenerator
    ): Response
    {
        if ($request->isMethod('POST')) {

            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(Usr::class)->findOneByEmail($email);


            if ($user === null) {
                $this->addFlash('danger', 'Email Inconnu');
                return $this->redirectToRoute('forgotten_password');
            }
            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('forgotten_password');
            }

            $url = $this->generateUrl('reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);

            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom(['TheKing@contact.tn' => 'The King Pizza'])
                ->setTo($user->getEmail())
                ->setBody(
                    "c'est le jeton pour réinitialiser votre mot de passe  : " . $url,
                    'text/html'
                );

            $mailer->send($message);

            $request->getSession()
                ->getFlashBag()
                ->add('success', 'Mail envoyé , vérifier votre boîte mail ');
            return $this->redirectToRoute('login');
        }
        return $this->render('default/forgetPass.html.twig');
    }



}
