<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraint as Assert; 
#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"il est vide")]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $tel = null;

    #[ORM\Column(length: 255)]
    private ?string $horairesConsultation = null;

    #[ORM\ManyToOne(inversedBy: 'Specialite')]
    private ?Specialite $idSpecialite = null;

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

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getHorairesConsultation(): ?string
    {
        return $this->horairesConsultation;
    }

    public function setHorairesConsultation(string $horairesConsultation): static
    {
        $this->horairesConsultation = $horairesConsultation;

        return $this;
    }

    public function getIdSpecialite(): ?Specialite
    {
        return $this->idSpecialite;
    }

    public function setIdSpecialite(?Specialite $idSpecialite): static
    {
        $this->idSpecialite = $idSpecialite;

        return $this;
    }
}
