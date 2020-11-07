<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class PersonneController
 * @package App\Controller
 * @Route("/todo")
 */
class ToDoController extends AbstractController
{
    /**
     * @Route("/", name="todo")
     */
    public function index(Request $request)
    {
        /*
         * Récupérer la session
         * Vérifier si ma session contient le tableau de todos
         *      Si ca n'existe pas
         *          Initialiser mon tableau et le mettre dans la session
         *
         * Afficher la liste des todos
         * */
        //Récupérer la session
        $session = $request->getSession();
        //Vérifier si ma session contient le tableau de todos
        //      Si ca n'existe pas
        if (! $session->has('mesTodos')) {
            //Initialiser mon tableau et le mettre dans la session
            $todos = array(
                'achat'=>'acheter clé usb',
                'cours'=>'Finaliser mon cours',
                'correction'=>'corriger mes examens'
            );
            $session->set('mesTodos', $todos);
            $this->addFlash('info', "La liste des todos a été initialisée avec succès");
        }
        return $this->render('to_do/index.html.twig');
    }
    /**
     * @Route("/add/{name}/{content}", name="todo.add")
     */
    public function addToDoAction(Request $request,$name,$content)
    {
        $session = $request->getSession();

        if($session->has('mesTodos')) {
            $todos = $session->get('mesTodos');
            
            if(isset($todos[$name])) {

                $this->addFlash('danger', "Le todo existe déjà");
            }else  {
                $todos[$name]= $content;
                $session->set('mesTodos', $todos);
                $this->addFlash('succ', "ajout avec succée");
            }

        }


        return $this->render('to_do/index.html.twig');

    }

    /**
     * @Route("/del/{name}", name="todo.del")
     */
    public function deleteToDoAction(Request $request,$name)
    {
        $session = $request->getSession();


        if($session->has('mesTodos')){
            $todos = $session->get('mesTodos');
            if(!isset($todos[$name])) {

                $this->addFlash('danger', "Le todo n'existe pas");
            }else {

                unset($todos[$name]);
                $this->addFlash('succ', "Le todo supprimé avec succès");
                $session->set('mesTodos', $todos);
            }
        }

        $session->set('mesTodos', $todos);
        return $this->render('to_do/index.html.twig');

    }
    /**
     * @Route("/todo/reset", name="todo.reset")
     */
    public function reset(Request $request)
    {
        $session = $request->getSession();

        if($session->has('mesTodos')){
            $todos = $session->get('mesTodos');

            $session->set('mesTodos', $todos);
        }


        return $this->render('to_do/index.html.twig');

    }
}
