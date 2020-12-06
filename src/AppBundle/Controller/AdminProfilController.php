<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Messages;
use AppBundle\Entity\Usr;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/Admin_Panel")
 */
class AdminProfilController extends Controller
{
    /**
     * @Route("/", name="admin")
     */
    public function indexAction(Request $request)
    {
        // if its not admin will redirect to 404 not found
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        // Find out how much users (clients)
        ////////////////////////////////////////////////////

        $repository = $this->getDoctrine()->getRepository(Usr::class);
        $client = $repository->findBy(
            ['roles' => ['["ROLE_USER"]']]
        );
        $nb_us = count($client);
        /////////////////////////////////////////////
        $D_Stock = $repository->findBy(
        ['roles' => ['["ROLE_STOCK"]']]
        );
        $nb_stock = count($D_Stock);
        /////////////////////////////////////////////
        $D_vente = $repository->findBy(
            ['roles' => ['["ROLE_VENTE"]']]
        );
        $nb_vente = count($D_vente);
        /////////////////////////////////////////////
        $livreur = $repository->findBy(
            ['roles' => ['["ROLE_Delivery"]']]
        );
        $nb_livreur = count($livreur);
        /////////////////////////////////////////////
        $gerant = $repository->findBy(
            ['roles' => ['["ROLE_GERANT"]']]
        );
        $nb_gerant = count($gerant);
        /////////////////////////////////////////////

        // Count the msgs :
        $rep = $this->getDoctrine()->getRepository(Messages::class);
        $messgeCount = $rep->findAll();
        $nbr_msg = count($messgeCount);


        return $this->render('admin/index.html.twig',array(
            'nb_us' => $nb_us,
            'nb_s' => $nb_stock,
            'nb_v' => $nb_vente,
            'nb_l' => $nb_livreur,
            'nb_g' => $nb_gerant,
            'msg' => $nbr_msg,
        ));
    }

    /**
     *
     * @Route("/profil", name="profil_ad")
     */
    public function ProfilAction()
    {
        // if its not admin will redirect to 404 not found
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Usr')->findBy([
            'id' => $user,]);
        return $this->render('admin/Profil_Admin.html.twig', array(
            'users' => $users,
            'user' => $user,
        ));
    }


    /**
     *
     *
     * @Route("/editadmin", name="edit_ad")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        // if its not admin will redirect to 404 not found
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Usr')->findBy([
            'id' => $user,]);
        $editForm = $this->createForm('AppBundle\Form\ProfilAdminType', $user);
        $editForm->handleRequest($request);

        //this after submit
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($user);
            $em->flush();

            //this is for alert msg
            /************************************/
            if ($editForm->isValid()) {
                // .. code that saves the user
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Vos informations ont été mises à jour');
                $url = $this->generateUrl('edit_ad');
                return $this->redirect($url);
            }

            /************************************/

            return $this->redirectToRoute('edit_ad');
        }

        return $this->render('admin/EditInfoAdmin.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
        ));
    }


    /**
     *
     * @Route("/security", name="securite")
     * @Method({"GET", "POST"})
     */
    public function editActionpassword(Request $request)
    {
        // if its not admin will redirect to 404 not found
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }

        /****************************************/
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Usr')->findBy([
            'id' => $user,]);
        $editForm = $this->createForm('AppBundle\Form\PassType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $em->persist($user);
            $em->flush();


            //this is for alert msg
            /************************************/
            if ($editForm->isValid()) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Votre mot de passe a été mis à jour !');


                $url = $this->generateUrl('securite');

                return $this->redirect($url);
            }

            /************************************/
            return $this->redirectToRoute('securite');
        }

        return $this->render('admin/securityPassword.html.twig', array(
            'users' => $users,
            'user' => $user,
            'edit_form' => $editForm->createView(),
        ));
    }



}
