<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Form\ProdutoType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProdutoController extends AbstractController
{
    /**
     *@Route("/produto", name="produto_index")
     */
    public function index()
    {
        
    }

    /**
     *@Route("/produto/adicionar", name="produto_adicionar")
     */
    public function adicionar(Request $request, EntityManagerInterface $em): Response
    {
        $msg = '';
        $produto = new Produto();
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //salvando
            $em->persist($produto);
            $em->flush();
            $msg = "Produto adicionada com sucesso";
        }


        $data['titulo'] = 'Adicionar Produto';
        $data['form'] = $form;
        $data['mensagem'] = $msg;

        return $this->renderForm('produto/form.html.twig', $data);
    }
}