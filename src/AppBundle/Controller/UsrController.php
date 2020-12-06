<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usr;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Usr controller.
 *
 * @Route("usr")
 */
class UsrController extends Controller
{


    //this is for show list client
    /**
     * Lists all usr entities.
     *
     * @Route("/", name="usr_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $em = $this->getDoctrine()->getManager();

        $usrs = $em->getRepository('AppBundle:Usr')->findBy(
            ['roles' => ['["ROLE_USER"]','[]']]
        );

        return $this->render('admin/usr/index.html.twig', array(
        'usrs' => $usrs,
        ));
    }

    //this is for show list "directeur de stock"
    /**
     *
     * @Route("/users_stock", name="usr_index_stock")
     * @Method("GET")
     */

    public function userstockAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $em = $this->getDoctrine()->getManager();

        $usrs = $em->getRepository('AppBundle:Usr')->findBy(
            ['roles' => ['["ROLE_STOCK"]']]
        );

        return $this->render('admin/usr/list_usr_stock.html.twig', array(
            'usrs' => $usrs,
        ));
    }


    //this is for show list "directeur de vente"
    /**
     *
     * @Route("/users_vente", name="usr_index_vente")
     * @Method("GET")
     */

    public function userventeAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $em = $this->getDoctrine()->getManager();

        $usrs = $em->getRepository('AppBundle:Usr')->findBy(
            ['roles' => ['["ROLE_VENTE"]']]
        );

        return $this->render('admin/usr/list_usr_vente.html.twig', array(
            'usrs' => $usrs,
        ));
    }



    //this is for show list "gerant"

    /**
     *
     * @Route("/users_gerant", name="usr_index_gerant")
     * @Method("GET")
     */

    public function usergerantAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $em = $this->getDoctrine()->getManager();

        $usrs = $em->getRepository('AppBundle:Usr')->findBy(
            ['roles' => ['["ROLE_GERANT"]']]
        );

        return $this->render('admin/usr/list_usr_gerant.html.twig', array(
            'usrs' => $usrs,
        ));
    }

    //this is for show list "livreur"

    /**
     *
     * @Route("/users_livreur", name="usr_index_livreur")
     * @Method("GET")
     */

    public function userlivreurAction()
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $em = $this->getDoctrine()->getManager();

        $usrs = $em->getRepository('AppBundle:Usr')->findBy(
            ['roles' => ['["ROLE_Delivery"]']]
        );

        return $this->render('admin/usr/list_usr_livreur.html.twig', array(
            'usrs' => $usrs,
        ));
    }














    // to insert new user
    /**
     * Creates a new usr entity.
     *
     * @Route("/new", name="usr_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        // if its not admin will redirect to 404 not found
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $us = $this->get('security.token_storage')->getToken()->getUser();

        $user = new Usr();
        $form = $this->createForm('AppBundle\Form\UsrType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);



            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('usr_show', array('id' => $user->getId()));
        }


        return $this->render('admin/usr/new.html.twig', array(
            'user' => $user,
            'user' => $us,
            'form' => $form->createView(),
        ));
    }



    // to show user info
    /**
     * Finds and displays a usr entity.
     *
     * @Route("/{id}", name="usr_show")
     * @Method("GET")
     */
    public function showAction(Usr $usr)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $deleteForm = $this->createDeleteForm($usr);

        return $this->render('admin/usr/show.html.twig', array(
            'usr' => $usr,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    // to modify the user

    /**
     * Displays a form to edit an existing usr entity.
     *
     * @Route("/{id}/edit", name="usr_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usr $usr)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $deleteForm = $this->createDeleteForm($usr);
        $editForm = $this->createForm('AppBundle\Form\UsrType', $usr);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            //this is for alert msg
            /************************************/
            if ($editForm->isValid()) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Vos informations ont été mises à jour !');


                $url = $this->generateUrl('usr_edit', array('id' => $usr->getId()));

                return $this->redirect($url);
            }

            /************************************/

            return $this->redirectToRoute('usr_edit', array('id' => $usr->getId()));
        }



        return $this->render('admin/usr/edit.html.twig', array(
            'usr' => $usr,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    // to delete the user
    /**
     * Deletes a usr entity.
     *
     * @Route("/delete/{id}", name="usr_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }

            $em = $this->getDoctrine()->getManager();
            $del = $em->getRepository(Usr::class)->find($id);
            $em->remove($del);
            $em->flush();


        return $this->redirectToRoute('usr_index');
    }

    /**
     * Creates a form to delete a usr entity.
     *
     * @param Usr $usr The usr entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usr $usr)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usr_delete', array('id' => $usr->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
