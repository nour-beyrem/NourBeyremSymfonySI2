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

    /**
     * @Route("/{personne}/{id?0}", name="piece_identite.edit")
     */
    public function editPieceIdentite(
        Personne $personne = null,
        $id,
        Request $request
    )
    {

        if (!$personne) {
            return $this->redirectToRoute('personne.list');
        } else {
            if ($id) {

                $repository = $this->getDoctrine()->getRepository(PieceIdentite::class);
                $pi = $repository->find($id);

                if (!$pi) {
                    $pi = new PieceIdentite();
                }
            } else {
                //Si on va faire une mise a jour on crée un objet vide
                $pi = new PieceIdentite();
            }
            //On crée le form
            $form = $this->createForm(PieceIdentiteType::class, $pi);
            $form->remove('updatedAt');
            $form->remove('createdAt');
            $form->remove('personne');
            $form->handleRequest($request);
            // Si c'est un post c'est une mise à jour ou un ajout on le fait au niveau
            // de la bd et on redirige vers le profil de la personne
            if ($form->isSubmitted()) {
                $pi->setPersonne($personne);
                $em = $this->getDoctrine()->getManager();
                $em->persist($pi);
                $em->flush();
                return $this->redirectToRoute('personne.detail', [
                    'id' => $personne->getId()
                ]);
            } else {
                // On veut juste afficher le formulaire
                return $this->render('piece_identite/index.html.twig', [
                    'form' => $form->createView()
                ]);
            }
        }
    }
}
