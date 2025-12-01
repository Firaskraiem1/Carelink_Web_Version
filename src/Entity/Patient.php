<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, name: "nomP")]
    #[Assert\NotBlank(allowNull: false, message: "Veuillez saisir votre nom.")]
    private ?string $nomP = null;

    #[ORM\Column(length: 255, name: "prenomP")]
    #[Assert\NotBlank(allowNull: false, message: "Veuillez saisir votre prenom.")]
    private ?string $prenomP = null;

    #[ORM\Column(length: 255, name: "emailP")]
    #[Assert\NotBlank(allowNull: false, message: "Veuillez saisir votre email .")]
    #[Assert\Regex(pattern: "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", message: "L'adresse email n'est pas valide.")]
    private ?string $email_P = null;

    #[ORM\Column(name: "numTelP")]
    #[Assert\NotBlank(allowNull: false, message: "Veuillez saisir votre numero de telephone .")]
    #[Assert\GreaterThan(value: 0, message: "le numero de telephone doit etre positive")]
    #[Assert\Length(min: 8, max: 8, exactMessage: "le numero de telephone doit contenir 8 nombres")]
    private ?int $numTelP = null;

    #[ORM\OneToOne(mappedBy: 'relationPatient', cascade: ['persist', 'remove'])]
    private ?FichePatient $relationFiche = null;

    #[ORM\OneToMany(targetEntity: ReservationRdv::class, mappedBy: 'patient', cascade: ['remove'])]
    private Collection $relation_rdv;

    #[ORM\Column(nullable: true)]
    private ?bool $blocked = null;

    #[ORM\Column(nullable: true, name: "nbr_annulations")]
    private ?int $nb_annulations = null;


    public function __construct()
    {
        $this->relation_rdv = new ArrayCollection();
    }


    public function getIdPatient(): ?int
    {
        return $this->id;
    }

    public function getNomP(): ?string
    {
        return $this->nomP;
    }

    public function setNomP(string $nomP): static
    {
        $this->nomP = $nomP;

        return $this;
    }

    public function getPrenomP(): ?string
    {
        return $this->prenomP;
    }

    public function setPrenomP(string $prenomP): static
    {
        $this->prenomP = $prenomP;

        return $this;
    }

    public function getEmailP(): ?string
    {
        return $this->email_P;
    }

    public function setEmailP(string $email_P): static
    {
        $this->email_P = $email_P;

        return $this;
    }

    public function getNumTelP(): ?int
    {
        return $this->numTelP;
    }

    public function setNumTelP(int $numTelP): static
    {
        $this->numTelP = $numTelP;

        return $this;
    }

    public function getRelationFiche(): ?FichePatient
    {
        return $this->relationFiche;
    }

    public function setRelationFiche(?FichePatient $relationFiche): static
    {
        // unset the owning side of the relation if necessary
        if ($relationFiche === null && $this->relationFiche !== null) {
            $this->relationFiche->setRelationPatient(null);
        }

        // set the owning side of the relation if necessary
        if ($relationFiche !== null && $relationFiche->getRelationPatient() !== $this) {
            $relationFiche->setRelationPatient($this);
        }

        $this->relationFiche = $relationFiche;

        return $this;
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
            $relationRdv->setPatient($this);
        }

        return $this;
    }

    public function removeRelationRdv(ReservationRdv $relationRdv): static
    {
        if ($this->relation_rdv->removeElement($relationRdv)) {
            // set the owning side to null (unless already changed)
            if ($relationRdv->getPatient() === $this) {
                $relationRdv->setPatient(null);
            }
        }

        return $this;
    }

    public function isBlocked(): ?bool
    {
        return $this->blocked;
    }

    public function setBlocked(bool $blocked): static
    {
        $this->blocked = $blocked;

        return $this;
    }

    public function getNbAnnulations(): ?int
    {
        return $this->nb_annulations;
    }

    public function setNbAnnulations(int $nb_annulations): static
    {
        $this->nb_annulations = $nb_annulations;

        return $this;
    }
}
