<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
#[ORM\Table(name: "medecincabinet")] 

class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le nom de cabinet ne peut pas être vide.")]
    private ?string $nomDeCabinet = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le numéro de téléphone ne peut pas être vide.")]
    private ?string $tel = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'adresse ne peut pas être vide.")]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'email ne peut pas être vide.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Les horaires ne peuvent pas être vides.")]
    private ?string $heures = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "L'ID de licence médicale ne peut pas être vide.")]
    private ?string $licenceMedicalId = null;

    #[ORM\Column(length: 255, nullable: true)]
   
    private ?string $imagePathProfile = null;

    #[ORM\Column(length: 255, nullable: true)]
   
    private ?string $fileLicencePath = null;

    #[ORM\Column(type: 'integer')]
    #[Assert\Choice(choices: [0, 1], message: "La valeur de 'active' doit être 0 ou 1.")]
    private ?int $active = 1;

    // Constructor with all attributes except 'id'
  
  

    // Getter and setter methods for all attributes

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDeCabinet(): ?string
    {
        return $this->nomDeCabinet;
    }

    public function setNomDeCabinet(string $nomDeCabinet): static
    {
        $this->nomDeCabinet = $nomDeCabinet;

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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getHeures(): ?string
    {
        return $this->heures;
    }

    public function setHeures(string $heures): static
    {
        $this->heures = $heures;

        return $this;
    }

    public function getLicenceMedicalId(): ?string
    {
        return $this->licenceMedicalId;
    }

    public function setLicenceMedicalId(string $licenceMedicalId): static
    {
        $this->licenceMedicalId = $licenceMedicalId;

        return $this;
    }

    public function getImagePathProfile(): ?string
    {
        return $this->imagePathProfile;
    }

    public function setImagePathProfile(string $imagePathProfile): static
    {
        $this->imagePathProfile = $imagePathProfile;

        return $this;
    }

    public function getFileLicencePath(): ?string
    {
        return $this->fileLicencePath;
    }

    public function setFileLicencePath(string $fileLicencePath): static
    {
        $this->fileLicencePath = $fileLicencePath;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): static
    {
        $this->active = $active;

        return $this;
    }
}
