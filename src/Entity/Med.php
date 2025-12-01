<?php

namespace App\Entity;

use App\Repository\MedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Table(name: "medecin")]
#[ORM\Entity(repositoryClass: MedRepository::class)]
class Med
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas etre vide.")]
    #[Assert\Length(
        min: 3,
        max: 25,
        minMessage: "Le nom il faut avoir au moins 3 lettres",
        maxMessage: "Le nom est trop long"
    )]
    #[Assert\Regex(
        pattern: '/^[A-Za-z]+$/',
        message: "Le nom ne peut contenir que des lettres alphabétiques."
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le prenom ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: '/^[A-Za-z]+$/',
        message: "Le prenom ne peut contenir que des lettres alphabétiques."
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'adresse de téléphone ne peut pas être vide.")]
    private ?string $adresse = null;


    #[ORM\Column(length: 255)]
    private ?string $specialité = null;

    #[ORM\OneToMany(targetEntity: ReservationRdv::class, mappedBy: 'medecin')]
    private Collection $relation_rdv;

    public function __construct()
    {
        $this->relation_rdv = new ArrayCollection();
    }
    /**
     * @return Collection<int, ReservationRdv>
     */
    public function getRelationRdv(): Collection
    {
        return $this->relation_rdv;
    }

    public function addRelationRdv(ReservationRdv $relationRdv): static
    {
        if (!$this->relation_rdv->contains($relationRdv)) {
            $this->relation_rdv->add($relationRdv);
            $relationRdv->setMedecin($this);
        }

        return $this;
    }

    public function removeRelationRdv(ReservationRdv $relationRdv): static
    {
        if ($this->relation_rdv->removeElement($relationRdv)) {
            // set the owning side to null (unless already changed)
            if ($relationRdv->getMedecin() === $this) {
                $relationRdv->setMedecin(null);
            }
        }

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }
    public function getSpecialité(): ?string
    {
        return $this->specialité;
    }

    public function setSpecialité(string $specialité): static
    {
        $this->specialité = $specialité;

        return $this;
    }
}
