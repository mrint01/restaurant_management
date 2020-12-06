<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Commande;
use AppBundle\Entity\Img_web;
use AppBundle\Entity\Output_web;
use AppBundle\Entity\Usr;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        // get the user name
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:Usr')->findBy([
            'id' => $user,]);
        ///////////////////////////////////////////////////////
        // Count the client(s) :
        $rep = $this->getDoctrine()->getRepository(Usr::class);
        $UsrCount = $rep->findBy(
            ['roles' => ['["ROLE_USER"]']]
        );
        $nbr_usr = count($UsrCount);
        ////////////////////////////////
        // Count the delived orders :
        $repee = $this->getDoctrine()->getRepository(Commande::class);
        $cmdCount = $repee->findBy(
            ['EtatCmd' => 'confirmer']
        );
        $nbr_cmd = count($cmdCount);
        ////////////////////////////////
        //get img from DataBase
        $rep = $this->getDoctrine()->getRepository(Img_web::class);
        $img = $rep->findOneBy(
            ['name' => 'BG_1']
        );
        /////////////////////
        $rep = $this->getDoctrine()->getRepository(Img_web::class);
        $img2 = $rep->findBy(
            ['name' => 'BG_2']
        );
        /////////////////////
        $rep = $this->getDoctrine()->getRepository(Img_web::class);
        $img3 = $rep->findBy(
            ['name' => 'BG_3']
        );
        /////////////////////
        $rep = $this->getDoctrine()->getRepository(Img_web::class);
        $img4= $rep->findBy(
            ['name' => 'img_story']
        );
        /////////////////////
        $rep = $this->getDoctrine()->getRepository(Img_web::class);
        $img5= $rep->findBy(
            ['name' => 'menu_pizza']
        );
        /////////////////////
        $rep = $this->getDoctrine()->getRepository(Img_web::class);
        $img6= $rep->findBy(
            ['name' => 'menu_sandwich']
        );
        /////////////////////
        $rep = $this->getDoctrine()->getRepository(Img_web::class);
        $img7= $rep->findBy(
            ['name' => 'menu_boissons']
        );

        // import data from DataBase
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data1 = $rep->findBy(
            ['name' => 'title']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data2 = $rep->findBy(
            ['name' => 'menu_1']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data3 = $rep->findBy(
            ['name' => 'menu_2']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data4 = $rep->findBy(
            ['name' => 'menu_3']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data5 = $rep->findBy(
            ['name' => 'menu_4']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data6 = $rep->findBy(
            ['name' => 'menu_5']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data7 = $rep->findBy(
            ['name' => 'story_title']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data8 = $rep->findBy(
            ['name' => 'story_description']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data9 = $rep->findBy(
            ['name' => 'food_title']
        );

        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data10 = $rep->findBy(
            ['name' => 'food_description']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data11 = $rep->findBy(
            ['name' => 'spcl_food_title']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data12 = $rep->findBy(
            ['name' => 'spcl_food_description']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data13 = $rep->findBy(
            ['name' => 'contact_hours']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data14 = $rep->findBy(
            ['name' => 'contact_direction']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data15 = $rep->findBy(
            ['name' => 'contact_email']
        );
        ////////////
        $rep = $this->getDoctrine()->getRepository(Output_web::class);
        $data16 = $rep->findBy(
            ['name' => 'contact_phone']
        );

        //Pizza
        $rep = $this->getDoctrine()->getRepository(Article::class);
        $pizza = $rep->findBy(
            ['typeArt' => 'pizza']
        );
        //Sandwich
        $rep = $this->getDoctrine()->getRepository(Article::class);
        $sandwich = $rep->findBy(
            ['typeArt' => 'sandwich']
        );
        //Boissons
        $rep = $this->getDoctrine()->getRepository(Article::class);
        $boissons = $rep->findBy(
            ['typeArt' => 'boissons']
        ); //spcl offer
        $rep = $this->getDoctrine()->getRepository(Article::class);
        $spcl_offr = $rep->findBy(
            ['typeArt' => 'spcl_offr']
        );

        /////////////////////////////////////
        $session = $request->getSession();
        if(!$session->has('panier'))
            $articles =0;
        else
            $articles = count($session->get('panier'));

        /////////////////////////////////////////
        return $this->render('default/index.html.twig',array(
            'nbr_usr' => $nbr_usr,
            'bg_1' => $img,
            'bg_2' => $img2,
            'bg_3' => $img3,
            'img_story' => $img4,
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
            'data4' => $data4,
            'data5' => $data5,
            'data6' => $data6,
            'data7' => $data7,
            'data8' => $data8,
            'data9' => $data9,
            'data10' => $data10,
            'data11' => $data11,
            'data12' => $data12,
            'data13' => $data13,
            'data14' => $data14,
            'data15' => $data15,
            'data16' => $data16,
            'img5' => $img5,
            'img6' => $img6,
            'img7' => $img7,
            'pizza' => $pizza,
            'sandwich' => $sandwich,
            'boissons' => $boissons,
            'spcloffr' => $spcl_offr,
            'articles' =>$articles,
            'users' => $users,
            'nbr_cmd' => $nbr_cmd,
        ));
    }


    /**
     * @Route("/login", name="authentification")
     */

    public function logAction(Request $request, AuthenticationUtils $authenticationUtils )
    {
        $authChecker = $this->container->get('security.authorization_checker');


        if($authChecker->isGranted(['ROLE_ADMIN']))
        {
            return $this->redirectToRoute('admin');

        }

        else if ($authChecker->isGranted(['ROLE_USER']) or $authChecker->isGranted([]) )
        {

            return $this->redirectToRoute('user' );

        }
        else if ($authChecker->isGranted(['ROLE_GERANT']))
        {

            return $this->redirectToRoute('gerant' );

        }
        else if ($authChecker->isGranted(['ROLE_stock']))
        {

            return $this->redirectToRoute('D_stock' );

        }
        else if ($authChecker->isGranted(['ROLE_Vente']))
        {

            return $this->redirectToRoute('D_Vente' );

        }
        else if ($authChecker->isGranted(['ROLE_Delivery']))
        {

            return $this->redirectToRoute('D_man' );

        }
        else {
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
            return $this->render('default/login.html.twig', array(
                'error'         => $error
            ));
        }
    }

}
