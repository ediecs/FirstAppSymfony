<?php

namespace App\Controller;

use App\Entity\Produto;
use App\Form\ProdutoType;
use App\Repository\ProdutoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProdutoController extends AbstractController
{
    /**
     *@Route("/produto", name="produto_index")
     */
    public function index(ProdutoRepository $produtoRepository)
    {
        $data['titulo'] = 'Gerenciar Produtos';
        $data['produtos'] = $produtoRepository->findAll();
        return $this->render('produto/index.html.twig', $data);
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

    /**
     *@Route("/produto/editar/{id}", name="produto_editar")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, ProdutoRepository $produtoRepository): Response
    {
        $msg = '';
        $produto = $produtoRepository->find($id);
        $form = $this->createForm(ProdutoType::class, $produto);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            $msg = "Produto editado com sucesso";
        }
        $data['titulo'] = 'Editar Produto';
        $data['form'] = $form;
        $data['mensagem'] = $msg;
        return $this->renderForm('produto/form.html.twig', $data);
    }

    /**
     *@Route("/produto/excluir/{id}", name="produto_excluir")
     */
    public function excluir($id, EntityManagerInterface $em, ProdutoRepository $produtoRepository)
    {
        $produto = $produtoRepository->find($id);
        $em->remove($produto);
        $em->flush();
        return $this->redirectToRoute("produto_index");
    }
}