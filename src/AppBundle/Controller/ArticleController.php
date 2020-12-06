<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/article")
 */
class ArticleController extends Controller
{
    /**
     * @Route("/" , name="article")
     */
    public function IndexAction()
    {


        $rep = $this->getDoctrine()->getRepository(Article::class);
        $pizza = $rep->findBy(
            ['typeArt' => 'pizza']
        );
        return $this->render('admin/Gestion_site/article/index.html.twig', array(
            'pizza' => $pizza,

        ));
    }


    /**
     * @Route("/sandwich" , name="article_sandwich")
     */
    public function Index_sandwichAction()
    {


        $rep = $this->getDoctrine()->getRepository(Article::class);
        $pizza = $rep->findBy(
            ['typeArt' => 'sandwich']
        );
        return $this->render('admin/Gestion_site/article/index_sandwich.html.twig', array(
            'pizza' => $pizza,

        ));
    }

    /**
     * @Route("/boissons" , name="article_boissons")
     */
    public function Index_boissonsAction()
    {


        $rep = $this->getDoctrine()->getRepository(Article::class);
        $pizza = $rep->findBy(
            ['typeArt' => 'boissons']
        );
        return $this->render('admin/Gestion_site/article/index_boissons.html.twig', array(
            'pizza' => $pizza,

        ));
    }

    /**
     * @Route("/offresSPCL" , name="offr_spc")
     */
    public function Index_OffreSPCLsAction()
    {


        $rep = $this->getDoctrine()->getRepository(Article::class);
        $pizza = $rep->findBy(
            ['typeArt' => 'spcl_offr']
        );
        return $this->render('admin/Gestion_site/article/index_offreSPCL.html.twig', array(
            'pizza' => $pizza,

        ));
    }






    // to insert new user
    /**
     * Creates a new usr entity.
     *
     * @Route("/new", name="article_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        // if its not admin will redirect to 404 not found
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $us = $this->get('security.token_storage')->getToken()->getUser();

        $art = new Article();
        $form = $this->createForm('AppBundle\Form\ArticleType', $art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            /**
             *@var UploadedFile $file
             *
             */

            $file = $art->getImageArt();
            $filename = '/img/'.(md5(uniqid()).'.'.$file->guessExtension());
            $file->move(
                $this->getParameter('img_directory'),$filename);
            $art->setImageArt($filename);
            $em=$this->getDoctrine()->getManager();
            $em->persist($art);
            $em->flush();

            return $this->redirectToRoute('article', array('id' => $art->getId()));
        }


        return $this->render('admin/Gestion_site/article/new_article.html.twig', array(
            'article' => $art,
            'user' => $us,
            'form' => $form->createView(),
        ));
    }






    // to modify the article

    /**
     * Displays a form to edit an existing usr entity.
     *
     * @Route("/{id}/edit", name="art_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Article $art)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        $deleteForm = $this->createDeleteForm($art);
        $editForm = $this->createForm('AppBundle\Form\ArticleType', $art);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            /**
             *@var UploadedFile $file
             *
             */

            $file = $art->getImageArt();
            $filename = '/img/'.(md5(uniqid()).'.'.$file->guessExtension());
            $file->move(
                $this->getParameter('img_directory'),$filename);
            $art->setImageArt($filename);
            $em=$this->getDoctrine()->getManager();
            $em->persist($art);
            $em->flush();

            //this is for alert msg
            /************************************/
            if ($editForm->isValid()) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Vos informations ont été mises à jour !');


                $url = $this->generateUrl('art_edit', array('id' => $art->getId()));

                return $this->redirect($url);
            }

            /************************************/

            return $this->redirectToRoute('art_edit', array('id' => $art->getId()));
        }



        return $this->render('admin/Gestion_site/article/edit_article.html.twig', array(
            'article' => $art,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }





    // to delete the article
    /**
     * Deletes a article entity.
     *
     * @Route("/delete/{id}", name="art_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }

        $em = $this->getDoctrine()->getManager();
        $del = $em->getRepository(Article::class)->find($id);
        $em->remove($del);
        $em->flush();


        return $this->redirectToRoute('article');
    }

    /**
     * Creates a form to delete a usr entity.
     *
     * @param Article $art The usr entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $art)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('art_delete', array('id' => $art->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}
