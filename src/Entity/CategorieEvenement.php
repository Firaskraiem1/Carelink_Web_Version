<?php

namespace App\Entity;

use App\Repository\CategorieEvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieEvenementRepository::class)]
class CategorieEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /*#[ORM\Column]
    private ?int $idCatEvenement = null;*/

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le type ne peut pas être vide")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "Le type doit contenir au moins 3 caractères"
    )]    
    private ?string $nomCategorie = null;

    #[ORM\OneToMany(mappedBy: 'idCatEvenement', targetEntity: Evenement::class)]
    private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /*public function getIdCatEvenement(): ?int
    {
        return $this->idCatEvenement;
    }

    public function setIdCatEvenement(int $idCatEvenement): static
    {
        $this->idCatEvenement = $idCatEvenement;

        return $this;
    }*/

    public function getNomCategorie(): ?string
    {
        return $this->nomCategorie;
    }

    public function setNomCategorie(string $nomCategorie): static
    {
        $this->nomCategorie = $nomCategorie;

        return $this;
    }

    /**
     * @return Collection<int, Evenement>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Evenement $relation): static
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->setIdCatEvenement($this);
        }

        return $this;
    }

    public function removeRelation(Evenement $relation): static
    {
        if ($this->relation->removeElement($relation)) {
            // set the owning side to null (unless already changed)
            if ($relation->getIdCatEvenement() === $this) {
                $relation->setIdCatEvenement(null);
            }
        }

        return $this;
    }
}
