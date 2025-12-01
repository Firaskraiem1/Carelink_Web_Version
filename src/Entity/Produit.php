<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;


#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[Vich\Uploadable]
class Produit
{

#[ORM\Id]
#[ORM\GeneratedValue]
#[ORM\Column]
private ?int $id = null;


#[ORM\Column(length: 255)]
#[Assert\NotBlank(message: "Nom du produit est obligatoire")]
#[Assert\Regex(pattern: "/^[a-zA-Z]+$/",message: "Nom du produit ne doit pas contenir de chiffres")]
private string $nom_prod;


#[ORM\Column]
#[Assert\NotBlank(message: "Prix du produit est obligatoire")]
#[Assert\GreaterThanOrEqual(0, message: "Prix ne doit pas être negatif")]
private float $prix_prod;

#[ORM\Column]
#[Assert\NotBlank(message: "Stock du produit est obligatoire")]
#[Assert\GreaterThanOrEqual(0, message: "Stock ne doit pas être negatif")]
private int $stock_prod;

#[ORM\ManyToOne(inversedBy: 'update_Prod')]
#[ORM\JoinColumn(nullable: false)]
private ?CategorieProd $id_C;



#[ORM\Column(length: 255, nullable:true)]
private ?string $image = null;



#[ORM\Column(length: 255, nullable: true)]
#[Assert\NotBlank(message: "Description est obligatoire")]
#[Assert\Regex(pattern: "/^[a-zA-Z]+$/",message: "Description ne doit pas contenir de chiffres")]
private ?string $description = null;

public function getImage(): ?string
{
    return $this->image;
}

public function setImage(?string $image): void
{
    $this->image = $image;
}

//////////////////////////////
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



public function getDescription(): ?string
{
    return $this->description;
}

public function setDescription(?string $description): static
{
    $this->description = $description;

    return $this;
}
}
