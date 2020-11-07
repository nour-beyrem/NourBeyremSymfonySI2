<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Form\PersonneType;
use App\Entity\PieceIdentite;
use App\Form\PieceIdentiteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PieceIdentiteController extends AbstractController
{
    /**
     * @Route("/piece/{id}", name="piece_identite")
     */
    public function index(Request $request, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Personne::class);


        $personne = $repository->find($id);
        if(!($personne->getPieceIdentite())){
            $piece = new PieceIdentite();
            $form = $this->createForm(PieceIdentiteType::class, $piece);
            $form->remove('createdAt');
            $form->remove('updatedAt');
            $form->remove('personne');
            $form->handleRequest($request);
            if ($form->isSubmitted()){
                $em= $this->getDoctrine()->getManager();
                $em->persist($piece);
                $em->flush();
                $personne->setPieceIdentite($piece);
                $em->persist($personne);
                $em->flush();
                return $this->render('personne/detail.html.twig', ['personne' => $personne]);
        }

        } else if ($personne->getPieceIdentite()){
           $piece=$personne->getPieceIdentite();
            $form = $this->createForm(PieceIdentiteType::class, $piece);
            $form->remove('createdAt');
            $form->remove('updatedAt');
            $form->remove('personne');
            $form->handleRequest($request);
            if ($form->isSubmitted()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($piece);
                $em->flush();
                $personne->setPieceIdentite($piece);
                $em->persist($personne);
                $em->flush();
                return $this->render('personne/detail.html.twig', ['personne' => $personne]);
            }
        }
        return $this->render('piece_identite/index.html.twig', [
            'form' => $form->createView()
        ]);

        }


}
