<?php

namespace App\Form;

use App\Entity\Categoria;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ProdutoType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nome_produto', TextType::class, ['label' => 'Nome do Produto '])
            ->add('valor', TextType::class, ['label' => 'Valor '])
            ->add('categoria', EntityType::class, ['label' => 'Categoria ', 'class' => Categoria::class, 'choice_label' => 'descricao_categoria'])
            ->add('Salvar', SubmitType::class);
    }
}