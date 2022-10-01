<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoriaController extends AbstractController
{
    /**
     *@Route("/categoria", name="categoria_index")
     */
    public function index(CategoriaRepository $categoriaRepository): Response
    {
        //buscar no bd as categorias
        $data['titulo'] = 'Gerenciar categorias';
        $data['categorias'] = $categoriaRepository->findAll();
        return $this->render('categoria/index.html.twig', $data);
    }   

    /**
     *@Route("/categoria/adicionar", name="categoria_adicionar")
     */
    public function adicionar(Request $request, EntityManagerInterface $em): Response
    {
        $msg = '';
        $categoria = new Categoria();
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //salvando
            $em->persist($categoria);
            $em->flush();
            $msg = "Categoria adicionada com sucesso";
        }
        $data['titulo'] = 'Adicionar Categoria';
        $data['form'] = $form;
        $data['mensagem'] = $msg;
        return $this->renderForm('categoria/form.html.twig', $data);
    }
}