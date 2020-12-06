<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Messages;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class MessagesAdminController extends Controller
{
    /**
     * @Route("messages" , name="msg")
     */
    public function IndexAction()
    {

        // if its not admin will redirect to 404 not found
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }


        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('AppBundle:Messages')->findAll();
        return $this->render('admin/messages_admin.html.twig', array(
           'messages' => $messages,
        ));
    }



    /**
     * @Route("message/delete/{id}" , name="msg_delete")
     */
    public function MessageDeleteAction($id)
    {

        // if its not admin will redirect to 404 not found
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }

        $em = $this->getDoctrine()->getManager();
        $del = $em->getRepository(Messages::class)->find($id);
        $em->remove($del);
        $em->flush();


        return $this->redirectToRoute('msg');
    }

}
