<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PatientRepository::class)]
class Patient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomP = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomP = null;

    #[ORM\Column(length: 255)]
    private ?string $email_P = null;

    #[ORM\Column]
    private ?int $numTelP = null;

    #[ORM\OneToOne(mappedBy: 'relationPatient', cascade: ['persist'])]
    private ?FichePatient $relationFiche = null;

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
}
