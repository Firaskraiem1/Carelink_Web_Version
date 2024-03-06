<?php

namespace App\Entity;

use App\Repository\ReservationRdvRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservationRdvRepository::class)]
class ReservationRdv
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan("today", message: "La date ne doit pas être dans le passé.")]
    private ?\DateTimeInterface $date_rdv = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(allowNull: false, message: "Veuillez saisir votre motif.")]
    private ?string $motif = null;

    #[ORM\ManyToOne(inversedBy: 'relation_rdv')]
    private ?Patient $patient = null;

    #[ORM\ManyToOne(inversedBy: 'relation_rdv')]
    private ?Medecin $medecin = null;

    #[ORM\Column(length: 255)]
    private ?string $remarques = null;

    #[ORM\Column(nullable: true)]
    private ?int $nbrAnnulations = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRdv(): ?\DateTimeInterface
    {
        return $this->date_rdv;
    }

    public function setDateRdv(\DateTimeInterface $date_rdv): static
    {
        $this->date_rdv = $date_rdv;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): static
    {
        $this->patient = $patient;

        return $this;
    }

    public function getMedecin(): ?Medecin
    {
        return $this->medecin;
    }

    public function setMedecin(?Medecin $medecin): static
    {
        $this->medecin = $medecin;

        return $this;
    }

    public function getRemarques(): ?string
    {
        return $this->remarques;
    }

    public function setRemarques(string $remarques): static
    {
        $this->remarques = $remarques;

        return $this;
    }

    public function getNbrAnnulations(): ?int
    {
        return $this->nbrAnnulations;
    }

    public function setNbrAnnulations(?int $nbrAnnulations): static
    {
        $this->nbrAnnulations = $nbrAnnulations;

        return $this;
    }
}
