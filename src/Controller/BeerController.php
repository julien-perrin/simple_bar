<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use App\Entity\Beer;
use App\Form\BeerFormType;


/**
* @Route("/admin")
*/

class BeerController extends AbstractController
{
    /**
    * @Route("/beer/create", name="admin.create.beer", methods={"GET", "POST"})
    */
    public function createBeer(Request $request){
        // ... création du formulaire
        $form = $this->createForm(BeerFormType::class, new Beer());
        // ...

        // récupère la Request avec les données du form
        $form->handleRequest($request);
        // Si le formulaire a été envoyé et est valide
        if($form->isSubmitted() && $form->isValid()){
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($form->getData());
            $manager->flush();
            // redirection vers la page index en accord avec
            // les routes de votre projet
            return $this->redirectToRoute('admin.index.beer');
        }

        return $this->render('beer/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
    * @Route("/beer/submitted", name="admin.index.beer")
    */
    public function submitted(){

        return $this->render('beer/submitted.html.twig', [
            'title' => 'Form submitted'
        ]);

    }

}
