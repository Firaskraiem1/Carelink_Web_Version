<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom ne peut pas etre vide.")]
    #[Assert\Length(
        min: 3,
        max:25,
        minMessage:"Le nom il faut avoir au moins 3 lettres", 
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
    #[Assert\NotBlank(message: "Le numéro de téléphone ne peut pas être vide.")]
    #[Assert\Regex(
        pattern: '/^\d{8}$/',
        message: "Le numéro de téléphone doit contenir exactement 8 chiffres."
    )]
    private ?string $tel = null;

    #[ORM\Column(length: 255)]
    // #[Assert\Regex(
    //     pattern: '/^(0?[1-9]|1[0-2]):[0-5][0-9](AM|PM)-(0?[1-9]|1[0-2]):[0-5][0-9](AM|PM)$/',
    //     message: "Le format de horaires de consultations doit etre sous le forma hh:mm[AM|PM]-hh:mm[AM|PM]"
    // )]
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