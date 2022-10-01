<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HelloController extends AbstractController{

    public function index() : Response
    {
        return new Response('<h1>Olá Mundo</h1>');
    }

    public function helloName($name) : Response
    {
        return new Response('<h1>Olá '. $name . ' Mundo</h1>');
    }


}