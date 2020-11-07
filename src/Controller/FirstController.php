<?php

namespace App\Controller;

use ContainerOMclY1Y\getResponseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;

class FirstController extends AbstractController
{
    /**
     * @Route("/first/{name}", name="first")
     */
    public function index($name)
    {

        return $this->render('first/index.html.twig', [
            'nour' => $name,
        ]);
    }

    /**
     * @Route("/form", name="test.form")
     */
    public function showFirstForm(Request $request)
    {
        //Création du formulaire
        $form = $this->createForm(ExempleType::class);
        // Requete en GET => afficher la page
        // Requete en POST => Gérer le formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            dd($form->getData());
        } else {
            return $this->render('test/form.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

}
