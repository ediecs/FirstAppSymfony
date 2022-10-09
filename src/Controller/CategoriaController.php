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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CategoriaController extends AbstractController
{
    /**
     *@Route("/categoria", name="categoria_index")
     *@IsGranted("ROLE_USER")
     */
    public function index(CategoriaRepository $categoriaRepository, Request $request)
    {
        //buscar no bd as categorias
        $descricaoCategoria = $request->query->get('descricao');
        $data['categorias'] = is_null($descricaoCategoria)
                            ? $categoriaRepository->findAll()
                            : $categoriaRepository->findCategoriaByLikeDescricao($descricaoCategoria);
        
        $data['descricaoCategoria'] = $descricaoCategoria;
        $data['titulo'] = 'Gerenciar categorias';
        return $this->render('categoria/index.html.twig', $data);
    }   

    /**
     *@Route("/categoria/adicionar", name="categoria_adicionar")
     *@IsGranted("ROLE_USER")
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

     /**
     *@Route("/categoria/editar/{id}", name="categoria_editar")
     *@IsGranted("ROLE_USER")
     */
    public function editar($id, Request $request, EntityManagerInterface $em, CategoriaRepository $categoriaRepository): Response
    {
        $msg = "";

        $categoria = $categoriaRepository->find($id);
        $form = $this->createForm(CategoriaType::class, $categoria);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $msg = "Categoria editada com sucesso";
        }

        $data['titulo'] = 'Editar Categoria';
        $data['form'] = $form;
        $data['mensagem'] = $msg;
        return $this->renderForm('categoria/form.html.twig', $data);
    }

     /**
     *@Route("/categoria/excluir/{id}", name="categoria_excluir")
     *@IsGranted("ROLE_USER")
     */
    public function excluir($id, EntityManagerInterface $em, CategoriaRepository $categoriaRepository): Response
    {
        $categoria = $categoriaRepository->find($id);
        $em->remove($categoria);
        $em->flush();

        //Retornar para a index
        return $this->redirectToRoute("categoria_index");
    }

}