<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;

use App\Entity\Beer;

use App\Entity\Country;

use App\Entity\Category;

// ajoutez l'alias suivant pour gérer les routes
use Symfony\Component\Routing\Annotation\Route;

class BarController extends AbstractController
{

    private $beers = [
        "Philomenn Blonde, 5,6 %",
        "Philomenn Rousse, 6,0 %",
        "Philomenn Stout, 4,5 %",
        "Philomenn Triple 'Spoum', 9,0 %",
        "Philomenn Blonde Tourbée, au malt fumé à la Tourbée, 8,0 %",
        "Philomenn Blanche, 5,6 %",
        "Philomenn Brune 'Spoum des Talus', bière millésimée à la mûre sauvage, 7,0-8,5 %",
        "Philomenn HAC, bière blonde houblonnée à cru, 6,5 %",
    ];

    private $belgiumBeers = [
        "Leffe",
        "Affligem"
    ];

    /**
    * @Route("/", name="home")
    */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Beer::class);
        $beers = $repository->findAll();

        $repository = $this->getDoctrine()->getRepository(Category::class);
        dump($repository->findByTerm('special'));

        return $this->render('bar/home.html.twig', [
            'controler name' => 'BarController',
            'title' => 'Hello World',
            'beers' => $beers
        ]);
    }

    /**
    * @Route("/beer/{id}", name="show_beer")
    */
    public function show(string $id){
        return $this->render('bar/beer.html.twig', [
            'title' => 'Belgium Beers',
            'belgiumBeers' => $this->belgiumBeers
            
        ]);
    }

    /**
    * @Route("/country-beer/{id}", name="country_beer")
    */
    public function showBeerCountry(string $id){

        $repository = $this->getDoctrine()->getRepository(Country::class);
        $country = $repository->find($id);

        return $this->render('bar/country.html.twig', [
            'title' => 'Beers per country',
            'beers' => $country->getBeers(),
            'country' => $country
            
        ]);
    }

    /**
    * @Route("/newbeer", name="create_beer")
    */
    public function createBeer(){
        $entityManager = $this->getDoctrine()->getManager();

        $beer = new Beer();
        $beer->setName('Leffe');
        $beer->setPublishedAt(new \DateTime());
        $beer->setDescription("Bière d'Abbaye");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($beer);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new beer with id '.$beer->getId());
    }

    public function mainMenu(string $routeName, array $params = null) {

        $repository = $this->getDoctrine()->getRepository(Category::class);

        dump($params);

        return $this->render (
            'partials/menu.html.twig',
            [
                'categories' => $repository->findByTerm('normal'),
                'routeName' => $routeName,
                'id' => $params['id'] ?? null
            ]
        );


    }

    /**
    * @Route("/category/{id}", name="category_beers")
    */
    public function category(string $id){

        $repository = $this->getDoctrine()->getRepository(Category::class);
        $category = $repository->find($id);

        //return $this->json('hello');
        return $this->render('bar/category.html.twig', [
            'title' => 'Beers per category',
            'beers' => $category->getBeers(),
            'category' => $category
        ]);

    }
}