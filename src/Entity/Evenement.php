<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
class Evenement
{
    const STATUS_PENDING = 'en attente';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //#[ORM\Column]
    //private ?int $idEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le titre ne peut pas être vide")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "Le titre doit contenir au moins 3 caractères"
    )]
    private ?string $titreEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le type ne peut pas être vide")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "Le type doit contenir au moins 3 caractères"
    )]       
    private ?string $TypeEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le lieu ne peut pas être vide")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "Le lieu doit contenir au moins 3 caractères"
    )]       
    private ?string $lieuEvenement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\GreaterThan("today", message: "La date ne doit pas être dans le passé.")]
    private ?\DateTimeInterface $dateEvenement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La description ne peut pas être vide")]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: "La description doit contenir au moins 3 caractères"
    )]       
    private ?string $descEvenement = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    private ?CategorieEvenement $idCatEvenement = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'evenement')]
    private Collection $commentaires;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'evenement')]
    private Collection $user;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    //public function getIdEvenement(): ?int
    //{
    //    return $this->idEvenement;
    //}

    //public function setIdEvenement(int $idEvenement): static
    //{
    /*    $this->idEvenement = $idEvenement;

        return $this;
    }*/

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
        return $this->TypeEvenement;
    }

    public function setTypeEvenement(string $TypeEvenement): static
    {
        $this->TypeEvenement = $TypeEvenement;

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

    public function getDateEvenement(): ?\DateTimeInterface
    {
        return $this->dateEvenement;
    }

    public function setDateEvenement(\DateTimeInterface $dateEvenement): static
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

    public function getIdCatEvenement(): ?CategorieEvenement
    {
        return $this->idCatEvenement;
    }

    public function setIdCatEvenement(?CategorieEvenement $idCatEvenement): static
    {
        $this->idCatEvenement = $idCatEvenement;

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

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): static
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setEvenement($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): static
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getEvenement() === $this) {
                $commentaire->setEvenement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Commentaire $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setEvenement($this);
        }

        return $this;
    }

    public function removeUser(Commentaire $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getEvenement() === $this) {
                $user->setEvenement(null);
            }
        }

        return $this;
    }
}
