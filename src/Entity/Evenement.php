<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titreEvenement = null;

    #[ORM\Column(length: 255)]
    private ?string $typeEvenement = null;

    #[ORM\Column(length: 255)]
    private ?string $lieuEvenement = null;

    #[ORM\Column(length: 255)]
    private ?string $dateEvenement = null;

    #[ORM\Column(length: 255)]
    private ?string $descEvenement = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'evenements')]
    private ?self $idCatEvenement = null;

    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'idCatEvenement')]
    private Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreEvenement(): ?string
    {
        return $this->titreEvenement;
    }

    public function setTitreEvenement(string $titreEvenement): static
    {
        $this->titreEvenement = $titreEvenement;

        return $this;
    }

    public function getTypeEvenement(): ?string
    {
        return $this->typeEvenement;
    }

    public function setTypeEvenement(string $typeEvenement): static
    {
        $this->typeEvenement = $typeEvenement;

        return $this;
    }

    public function getLieuEvenement(): ?string
    {
        return $this->lieuEvenement;
    }

    public function setLieuEvenement(string $lieuEvenement): static
    {
        $this->lieuEvenement = $lieuEvenement;

        return $this;
    }

    public function getDateEvenement(): ?string
    {
        return $this->dateEvenement;
    }

    public function setDateEvenement(string $dateEvenement): static
    {
        $this->dateEvenement = $dateEvenement;

        return $this;
    }

    public function getDescEvenement(): ?string
    {
        return $this->descEvenement;
    }

    public function setDescEvenement(string $descEvenement): static
    {
        $this->descEvenement = $descEvenement;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getIdCatEvenement(): ?self
    {
        return $this->idCatEvenement;
    }

    public function setIdCatEvenement(?self $idCatEvenement): static
    {
        $this->idCatEvenement = $idCatEvenement;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(self $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setIdCatEvenement($this);
        }

        return $this;
    }

    public function removeEvenement(self $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getIdCatEvenement() === $this) {
                $evenement->setIdCatEvenement(null);
            }
        }

        return $this;
    }
}
