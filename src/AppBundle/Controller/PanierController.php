<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commande;
use AppBundle\Entity\Usr;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @Route("/panier")
 */
class PanierController extends Controller
{
    /**
     * @Route("/",name="panier")
     */
    public function IndexAction(Request $request)
    {

        $session = $request->getSession();

        if(!$session->has('panier')){
            $session->set('panier',array());
        }
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('AppBundle:Article')->findArray(array_keys($session->get('panier')));


        return $this->render('panier/index.html.twig', array(
           'produits' => $produits,
            'panier' => $session->get('panier')
        ));
    }

    /**
     * @Route("/ajouter/{id}",name="ajouter")
     */
    public function ajouterAction(Request $request , $id)
    {

        $session = $request->getSession();
        if(!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');
        if(array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
        }else {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;
            }
        $session->set('panier',$panier);

            return $this->redirectToRoute('homepage');




    }

    /**
     * @Route("/update/{id}",name="update")
     */
    public function updateAction(Request $request , $id)
    {

        $session = $request->getSession();
        if(!$session->has('panier')) $session->set('panier',array());
        $panier = $session->get('panier');
        if(array_key_exists($id, $panier)) {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
        }else {
            if ($request->query->get('qte') != null)
                $panier[$id] = $request->query->get('qte');
            else
                $panier[$id] = 1;
        }
        $session->set('panier',$panier);


        return $this->redirectToRoute('panier');

    }

    /**
     * @Route("/supprimer/{id}",name="supprimer")
     */
    public function SupprimerAction(Request $request , $id)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');

        if(array_key_exists($id , $panier)){
            unset($panier[$id]);
            $session->set('panier' , $panier);
        }

        return $this->redirect($this->generateUrl('panier'));


    } /**
     * @Route("/adr_livraison",name="adrlivraison")
     */
    public function LivraisonAction()
    {

        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->redirect($this->generateUrl('login'));
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Usr')->findBy([
            'id' => $user,]);
        return $this->render('panier/livraison_adr.html.twig', array(
            'users' => $users,
            'user' => $user,
        ));

    }

    /**
     * @Route("/card_info",name="card")
     */
    public function CardAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Usr')->findBy([
            'id' => $user,]);
        return $this->render('panier/card_info.html.twig', array(
            'users' => $users,
            'user' => $user,
        ));

    }

    /**
     * @Route("/facture",name="facturefinal")
     */
    public function FactureAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Usr')->findBy([
            'id' => $user,]);

        /////////////////////////////////////////////////
        $session = $request->getSession();

        if(!$session->has('panier')){
            $session->set('panier',array());
        }
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('AppBundle:Article')->findArray(array_keys($session->get('panier')));


        ////////////////////////////////////////////

        return $this->render('panier/facture_final.html.twig', array(
            'users' => $users,
            'user' => $user,
            'produits' => $produits,
            'panier' => $session->get('panier')
        ));

    }









    /**
     * @Route("/verification",name="verif")
     */
    public function TestAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Usr')->findBy([
            'id' => $user,]);
        ///////////////////////////////////////////
        $session = $request->getSession();
        if(!$session->has('panier')){
            $session->set('panier',array());
        }
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('AppBundle:Article')->findArray(array_keys($session->get('panier')));
        ////////////////////////////////////////////
        // to get id of client
        //$id_user = $users[0]->getid();
        // to get articles names
        $artnames = "";
        $prix =0;
        foreach($produits as $i){

            $id = $i->getid();
            $session = $request->getSession();
            if(!$session->has('panier')) $session->set('panier',array());
            $panier = $session->get('panier');
            if(array_key_exists($id, $panier)) {
                //$qte = $request->query->get('qte');
                if ($request->query->get('qte') != null)
                    $panier[$id] = $request->query->get('qte');
                $qte = $panier[$id];

            }else {
                if ($request->query->get('qte') != null) {
                    $panier[$id] = $request->query->get('qte');
                    $qte = $panier[$id];
                }
                else
                    $panier[$id] = 1;
                $qte = $panier[$id];
            }
            $session->set('panier',$panier);
            // prix totale
            $prix = $prix + ($panier[$id] * $i->getPrixArt());
            //articles
            $artnames =$artnames.  " + " .$panier[$id]. " * (" .($i->getNameArt()) . ")";

        }
        $prixtotlat = $prix + 2;

        // insert to database
        $em = $this->getDoctrine()->getManager();
        $cmd = new Commande();
        $cmd->setIdClient($user);
        $cmd->setArticleName($artnames);
        $cmd->setPrixCmd($prixtotlat);
        $cmd->setDateCmd(new \DateTime());
        $cmd->setEtatCmd("En attente de confirmation");

        $em->persist($cmd);
        $em->flush();
        /////////////////////////////////////////////////


        return $this->render('panier/verification.html.twig');

    }





    /**
     * @Route("/del",name="supppanier")
     */
    public function AfterPayAction(Request $request)
    {

        $session = $request->getSession();
        if(!$session->has('panier')){
            $session->set('panier',array());
        }
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('AppBundle:Article')->findArray(array_keys($session->get('panier')));

        foreach($produits as $i) {

            $id = $i->getid();
            $session = $request->getSession();
            $panier = $session->get('panier');

            if (array_key_exists($id, $panier)) {
                unset($panier[$id]);
                $session->set('panier', $panier);
            }
        }




        return $this->redirect($this->generateUrl('homepage'));

    }
}
