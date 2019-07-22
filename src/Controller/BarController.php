<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

// ajoutez l'alias suivant pour gérer les routes
use Symfony\Component\Routing\Annotation\Route;

class BarController
{
    /**
    * @Route("/", name="home")
    */
    public function index()
    {
        return new Response('Hello Bar Controller');
    }
    /**
    * @Route("/beer/{slug}", name="show_beer")
    */
    public function show(string $slug)
    {
        return new Response("Hello $slug");
    }
}