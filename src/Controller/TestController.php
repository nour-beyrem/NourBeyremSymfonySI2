<?php

namespace App\Controller;

use App\Form\CvType;
use App\Form\ExempleType;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
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
           // die('send');
            dd($form->getData());
        } else {
            return $this->render('test/form.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
    /**
     * @Route("/cvv", name="test.cv")
     */
    public function showCv()
    {
        //Création du formulaire
        $form = $this->createForm(CvType::class, null , [
            'action' => $this->generateUrl('test.cv.process'),
            'method' => 'POST'
        ]);


            return $this->render('test/Cvform.html.twig', [
                'form' => $form->createView()
            ]);

    }

    /**
     * @Route("/showcv",name="test.cv.process")
     */
    public function processCvForm(Request $request)
    {
        $form = $this->createForm(CvType::class);
        $form->handleRequest($request);
        $cv = $form->getData();
        return $this->render('test/cv.html.twig', [
            'name' => $cv['name'],
            'firstname' => $cv['firstname'],
            'age' => $cv['age'],
            'section' => $cv['section'],
        ]);
    }
}
