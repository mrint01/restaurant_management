<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Img_web;
use AppBundle\Entity\Output_web;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
/**
 * @Route("gestion")
 */
class Siteweb_gerer_motsController extends Controller
{
    /**
     * @Route("/" , name="ger_site")
     */
    public function IndexAction()
    {
        // if its not admin will redirect to 404 not found
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        //////////////////////////////////////////////////////////////////////////////////////
        $repository = $this->getDoctrine()->getRepository(Output_web::class);
        $output = $repository->findAll();


        return $this->render('admin/Gestion_site/index.html.twig', array(
            'output' => $output,

        ));
    }

    /**
     * Displays a form to edit an existing usr entity.
     *
     * @Route("/{id}/edit", name="modif_site_ger")
     * @Method({"GET", "POST"})
     */
    public function ModifAction(Request $request, Output_web $out)
    {
        // if its not admin will redirect to 404 not found
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        //////////////////////////////////////////////////////////////////////////////////////

        $deleteForm = $this->createDeleteForm($out);
        $editForm = $this->createForm('AppBundle\Form\OutType', $out);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            //this is for alert msg
            /************************************/
            if ($editForm->isValid()) {
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Vos informations ont été mises à jour !');


                $url = $this->generateUrl('modif_site_ger', array('id' => $out->getId()));

                return $this->redirect($url);
            }

            /************************************/

            return $this->redirectToRoute('modif_site_ger', array('id' => $out->getId()));
        }



        return $this->render('admin/Gestion_site/edit_site.html.twig', array(
            'usr' => $out,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }


    // to delete the user
    /**
     * Deletes a usr entity.
     *
     * @Route("/delete/{id}", name="gestion_site_delete")
     * @Method("DELETE")
     */
    public function deleteAction($id)
    {
        ///////////////////////////////////////////////////////////////
        if (!$this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->render('default/404.html.twig');
        }
        ///////////////////////////////////////////////////////////////

        $em = $this->getDoctrine()->getManager();
        $del = $em->getRepository(Output_web::class)->find($id);
        $em->remove($del);
        $em->flush();


        return $this->redirectToRoute('ger_site');
    }

    /**
     * Creates a form to delete a usr entity.
     *
     * @param Output_web $out The usr entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Output_web $out)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gestion_site_delete', array('id' => $out->getId())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}
