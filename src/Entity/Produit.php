<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{

#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column]
private ?int $id = null;


#[ORM\Column(length: 255)]
#[Assert\NotBlank(message: "Product name is required")]
#[Assert\Regex(pattern: "/^[a-zA-Z]+$/", message: "Product name must contain only letters")]
private string $nom_prod;

#[ORM\Column]
#[Assert\NotBlank(message: "Product price is required")]
#[Assert\GreaterThanOrEqual(0, message: "Price cannot be negative")]


private float $prix_prod;

#[ORM\Column]
#[Assert\NotBlank(message: "Product stock is required")]
#[Assert\GreaterThanOrEqual(0, message: "Stock cannot be negative")]
private int $stock_prod;

#[ORM\ManyToOne(inversedBy: 'update_Prod')]
#[ORM\JoinColumn(nullable: false)]
private ?CategorieProd $id_C;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdProd(): ?int
    {
        return $this->id_prod;
    }

    public function setIdProd(int $id_prod): static
    {
        $this->id_prod = $id_prod;

        return $this;
    }

    public function getNomProd(): ?string
    {
        return $this->nom_prod;
    }

    public function setNomProd(string $nom_prod): static
    {
        $this->nom_prod = $nom_prod;

        return $this;
    }

    public function getPrixProd(): ?float
    {
        return $this->prix_prod;
    }

    public function setPrixProd(float $prix_prod): static
    {
        $this->prix_prod = $prix_prod;

        return $this;
    }

    public function getStockProd(): ?int
    {
        return $this->stock_prod;
    }

    public function setStockProd(int $stock_prod): static
    {
        $this->stock_prod = $stock_prod;

        return $this;
    }

    public function getIdC(): ?CategorieProd
{
    return $this->id_C;
}

public function setIdC(?CategorieProd $id_C): static
{
    $this->id_C = $id_C;

    return $this;
}
}
