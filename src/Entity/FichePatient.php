<?php

namespace App\Entity;

use App\Repository\FichePatientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FichePatientRepository::class)]
class FichePatient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(allowNull: false, message: "Veuillez saisir l'adresse.")]
    private ?string $adresse = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\GreaterThan("today", message: "La date ne doit pas être dans le passé.")]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column]
    #[Assert\GreaterThan(value: 0, message: "le poids doit etre positive")]
    #[Assert\NotBlank(allowNull: false, message: "Veuillez saisir le poids.")]
    private ?float $poids = null;

    #[ORM\Column]
    #[Assert\GreaterThan(value: 0, message: "la taille doit etre positive")]
    #[Assert\NotBlank(allowNull: false, message: "Veuillez saisir la taille.")]
    private ?float $taille = null;

    #[ORM\OneToOne(inversedBy: 'relationFiche', cascade: ['persist'])]
    #[Assert\NotBlank(allowNull: false, message: "Veuillez choisir un patient de la liste.")]
    private ?Patient $relationPatient = null;

    #[ORM\ManyToOne(inversedBy: 'relationFiche1')]
    private ?Medecin $relationMedecin = null;

    #[ORM\Column]
    #[Assert\GreaterThan(value: 0, message: "le code postal doit etre positive")]
    #[Assert\NotBlank(message: "Veuillez saisir le code postal.")]
    private ?int $Code_Postal = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir la ville.")]
    private ?string $Ville = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Veuillez saisir la maladie.")]
    private ?string $maladie = null;

    #[ORM\ManyToOne(inversedBy: 'relationFiche')]
    private ?Medecin $relation_medecin = null;


    public function getIdFiche(): ?int
    {
        return $this->id;
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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getPoids(): ?float
    {
        return $this->poids;
    }

    public function setPoids(float $poids): static
    {
        $this->poids = $poids;

        return $this;
    }

    public function getTaille(): ?float
    {
        return $this->taille;
    }

    public function setTaille(float $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getRelationPatient(): ?Patient
    {
        return $this->relationPatient;
    }

    public function setRelationPatient(?Patient $relationPatient): static
    {
        $this->relationPatient = $relationPatient;

        return $this;
    }

    public function getRelationMedecin(): ?Medecin
    {
        return $this->relationMedecin;
    }

    public function setRelationMedecin(?Medecin $relationMedecin): static
    {
        $this->relationMedecin = $relationMedecin;

        return $this;
    }

    public function getCodePostal(): ?int
    {
        return $this->Code_Postal;
    }

    public function setCodePostal(int $Code_Postal): static
    {
        $this->Code_Postal = $Code_Postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): static
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getMaladie(): ?string
    {
        return $this->maladie;
    }

    public function setMaladie(string $maladie): static
    {
        $this->maladie = $maladie;

        return $this;
    }
}
