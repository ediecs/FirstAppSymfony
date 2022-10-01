<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TesteController extends AbstractController
{
    /**
     * @Route("/teste", name="teste")
     */
    public function index(): Response
    {
        $data['titulo'] = 'Pagina de teste';
        return $this->render('teste/index.html.twig', $data);
    }

    /**
     * @Route("/teste/detalhes/{id}")
     */
    public function detalhes($id): Response
    {
        $data['id'] = $id;
        return $this->render('teste/detalhes.html.twig', $data);
    }
}