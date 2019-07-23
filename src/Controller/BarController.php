<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

// ajoutez l'alias suivant pour gérer les routes
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{
    /**
    * @Route("/", name="home")
    */
    public function index()
    {
        return $this->render('bar/home.html.twig', [
            'title' => 'Hello World'
        ]);
    }

    /**
    * @Route("/beer/{slug}", name="show_beer")
    */
    public function show(string $slug){
        $beers = [
            "Philomenn Blonde, 5,6 %",
            "Philomenn Rousse, 6,0 %",
            "Philomenn Stout, 4,5 %",
            "Philomenn Triple 'Spoum', 9,0 %",
            "Philomenn Blonde Tourbée, au malt fumé à la Tourbée, 8,0 %",
            "Philomenn Blanche, 5,6 %",
            "Philomenn Brune 'Spoum des Talus', bière millésimée à la mûre sauvage, 7,0-8,5 %",
            "Philomenn HAC, bière blonde houblonnée à cru, 6,5 %",
        ];

        return $this->render('bar/beer.html.twig', [
            'title' => 'Beers',
            'beers' => $beers
        ]);
    }
}