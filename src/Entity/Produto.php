<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProdutoRepository::class)]
class Produto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("api_list")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(
        message:'Esse campo deve ser preenchido.'
    )]
    #[Assert\Length(
        min: 3,
        max: 50,
        minMessage: 'O campo Nome do produto deve conter mais de {{ limit }} caracteres',
        maxMessage: 'O campo Nome do produto deve conter no máximo {{ limit }} caracteres',
    )]
    #[Groups("api_list")]
    private ?string $nomeProduto = null;

    #[ORM\Column]
    #[Assert\NotBlank(
        message:'Esse campo deve ser preenchido.'
    )]
    #[Assert\Positive(
        message:'Esse campo deve ser maior que zero.'
    )]
    #[Groups("api_list")]
    private ?float $valor = null;

    #[ORM\ManyToOne(inversedBy: 'produtos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("api_list")]
    private ?Categoria $categoria = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeProduto(): ?string
    {
        return $this->nomeProduto;
    }

    public function setNomeProduto(string $nomeProduto): self
    {
        $this->nomeProduto = $nomeProduto;

        return $this;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getCategoria(): ?Categoria
    {
        return $this->categoria;
    }

    public function setCategoria(?Categoria $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }
}
