<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
class Specialite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $sousSpecialite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $anneeExperience = null;

    #[ORM\OneToMany(targetEntity: Medecin::class, mappedBy: 'idSpecialite')]
    private Collection $specialite;

    public function __construct()
    {
        $this->specialite = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSousSpecialite(): ?string
    {
        return $this->sousSpecialite;
    }

    public function setSousSpecialite(string $sousSpecialite): static
    {
        $this->sousSpecialite = $sousSpecialite;

        return $this;
    }

    public function getAnneeExperience(): ?string
    {
        return $this->anneeExperience;
    }

    public function setAnneeExperience(string $anneeExperience): static
    {
        $this->anneeExperience = $anneeExperience;

        return $this;
    }

    /**
     * @return Collection<int, Medecin>
     */
    public function getSpecialite(): Collection
    {
        return $this->specialite;
    }

    public function addSpecialite(Medecin $specialite): static
    {
        if (!$this->specialite->contains($specialite)) {
            $this->specialite->add($specialite);
            $specialite->setIdSpecialite($this);
        }

        return $this;
    }

    public function removeSpecialite(Medecin $specialite): static
    {
        if ($this->specialite->removeElement($specialite)) {
            // set the owning side to null (unless already changed)
            if ($specialite->getIdSpecialite() === $this) {
                $specialite->setIdSpecialite(null);
            }
        }

        return $this;
    }
}
